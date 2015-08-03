<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 19/06/15
 * Time: 16:28
 */

namespace fr\manaur\buzzer;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\Wamp\Exception;
use Ratchet\WebSocket\Version\RFC6455\Connection;

class Serveur implements MessageComponentInterface {

    /**
     * @var int
     */
    private $lastCleaning;

    /**
     * @var SalonCollection
     */
    private $salons = null;

    /**
     * @var BuzzerCollection
     */
    private $buzzers = null;

    /**
     * @var Index
     */
    private $index = null;

    /**
     * @var Serveur
     */
    private static $instance = null;

    /**
     * @var \React\EventLoop\LoopInterface
     */
    private $loop;

    function __construct()
    {
        Conf::init();
        $this->salons = new SalonCollection();
        $this->buzzers = new BuzzerCollection();
        $this->index = new Index();
        $this->lastCleaning = time();
        self::$instance = $this;
        $this->log("Démarrage du serveur");
    }

    function __destruct()
    {
        $this->log("Stoppage du serveur");
    }


    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $connexion = new Connexion($conn);
        $this->log('Connexion #'.$connexion->getRessourceId());
        $this->index->addConnection($connexion);
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        /** @var Connection $conn */
        $this->log('Déconnexion #'.$conn->resourceId);
        $connexion = $this->index->getById($conn->resourceId);
        $connexion->onDisconnect();
        $this->index->removeConnectionById($connexion->getRessourceId());
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        /** @var Connection $conn */
        $this->log('[error] #'.$conn->resourceId.' - '.$e->getMessage());
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        /** @var Connection $from */
        $this->log('<#' . $from->resourceId . ' - ' . $msg);
        $msg = json_decode($msg);
        try {
            if (is_null($msg)) {
                throw new Exception("Message invalide, pas json_decodable");
            }
            if(!$this->index->isConnected($from->resourceId)) {
                throw new Exception("Connexion non indexée");
            }
            $connexion = $this->index->getById($from->resourceId);
            ActionFactory::make($msg, $connexion)->action();
        } catch(Exception $e) {
            $this->onError($from, $e);
        }
    }

    /**
     * Supprime les connecteds déconnectés depuis plus longtemps que DELAY_BETWEEN_CLEANING
     */
    function cleanConnecteds() {
        $this->log('Cleaning connecteds');
        $toRemove = array();
        foreach ($this->salons as $index => $salon) {
            /** @var Salon $salon */
            if ($salon->getDisconnectionTime() > 0 && $salon->getDisconnectionTime() < time() - Conf::getMaxDeconnexionTime()) {
                $toRemove[] = $index;
                $this->index->removeConnectedById($salon->getId());
            }
        }
        foreach ($toRemove as $index) {
            $this->log("clean ".$this->salons[$index]->getId());
            $this->salons[$index]->remove();
            unset($this->salons[$index]);
        }
        $toRemove = array();
        foreach ($this->buzzers as $index => $buzzer) {
            /** @var Buzzer $buzzer */
            if ($buzzer->getDisconnectionTime() > 0 && $buzzer->getDisconnectionTime() < time() - Conf::getMaxDeconnexionTime()) {
                $toRemove[] = $index;
                $this->index->removeConnectedById($buzzer->getId());
            }
        }
        foreach ($toRemove as $index) {
            $this->log("clean ".$this->buzzers[$index]->getId());
            $this->buzzers[$index]->remove();
            unset($this->buzzers[$index]);
        }
        $this->lastCleaning = time();
    }

    /**
     * Logge
     * @param string $txt
     */
    function log($txt) {
        echo date('[Y-m-d H:i:s] ').$txt."\n";
    }

    /**
     * @return Serveur
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * Stoppe le serveur
     */
    public static function stopInstance(){
        self::$instance->getLoop()->stop();
        self::$instance = null;
    }

    /**
     * @return Index
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Débug
     * @return string
     */
    function __toString() {
        $ret = "############################\n";
        $ret .= "Salons ----------------------------------------------------------------------- \n";
        $ret .= $this->salons;
        $ret .= "Buzzers ----------------------------------------------------------------------- \n";
        $ret .= $this->buzzers;
        $ret .= "Index ----------------------------------------------------------------------- \n";
        $ret .= $this->index;
        $ret .= "############################\n";
        return $ret;
    }

    /**
     * @return \React\EventLoop\LoopInterface
     */
    public function getLoop()
    {
        return $this->loop;
    }

    /**
     * @param \React\EventLoop\LoopInterface $loop
     */
    public function setLoop($loop)
    {
        $this->loop = $loop;
        $this->loop->addPeriodicTimer(Conf::getDelayBetweenCleaning(), array($this, 'cleanConnecteds'));
    }

    /**
     * @return SalonCollection
     */
    public function getSalons()
    {
        return $this->salons;
    }

    /**
     * @param SalonCollection $salons
     */
    public function setSalons($salons)
    {
        $this->salons = $salons;
    }

    /**
     * @return BuzzerCollection
     */
    public function getBuzzers()
    {
        return $this->buzzers;
    }

    /**
     * @param BuzzerCollection $buzzers
     */
    public function setBuzzers($buzzers)
    {
        $this->buzzers = $buzzers;
    }

    /**
     * @param int $idBuzzer
     * @return bool
     */
    public function buzzerExists($idBuzzer)
    {
        return isset($this->buzzers[$idBuzzer]);
    }

    /**
     * @param int $idSalon
     * @return bool
     */
    public function salonExists($idSalon)
    {
        return isset($this->salons[$idSalon]);
    }



}