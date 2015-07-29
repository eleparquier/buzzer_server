<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 22/06/15
 * Time: 13:15
 */

namespace fr\manaur\buzzer;

abstract class Connected
{
    /**
     * @var Connexion
     */
    private $connexion = null;

    /**
     * @var int
     */
    private $lastConnectionId = null;

    /**
     * @var Array
     */
    private static $numerotations = array();

    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var int
     */
    private $disconnectionTime = 0;

    /**
     * @param Connexion $conn
     */
    function __construct(Connexion $conn = null)
    {
        $this->setConnexion($conn);
        if(!isset(self::$numerotations[$this->className()])) self::$numerotations[$this->className()] = new Numerotation();
        $this->setId($this->className().self::$numerotations[$this->className()]->getNewId());
    }

    function __destruct() {
        self::$numerotations[$this->className()]->removeId($this->getId());
    }

    /**
     * @return Connexion
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * @param Connexion $connexion
     */
    public function setConnexion($connexion)
    {
        $this->connexion = $connexion;
        if(!is_null($connexion)) {
            $this->setLastConnectionId($connexion->getRessourceId());
            $this->setDisconnectionTime(0);
            $connexion->setConnected($this);
        }
    }

    /**
     * @return int
     */
    public function getConnectionId()
    {
        if(is_null($this->getConnexion())) return 0;
        return $this->getConnexion()->getRessourceId();
    }

    /**
     * Dit si la connection est toujours active
     * @return boolean
     */
    public function isConnected()
    {
    }

    /**
     * Événement sur déconnexion du client
     */
    public function onDisconnect()
    {
        $this->setLastConnectionId($this->getConnexion()->getRessourceId());
        $this->setDisconnectionTime(time());
        $this->setConnexion(null);
    }

    /**
     * @return int
     */
    public function getLastConnectionId()
    {
        return $this->lastConnectionId;
    }

    /**
     * @param int $lastConnectionId
     */
    public function setLastConnectionId($lastConnectionId)
    {
        $this->lastConnectionId = $lastConnectionId;
    }

    public function __toString()
    {
        $ret = $this->className().'Id='.$this->getId()." - ResourceId #".$this->getConnectionId().' - lastConnectionId #'.$this->getLastConnectionId().' - disconnectionTime='.$this->getDisconnectionTime();
        return $ret;
    }

    /**
     * @return string
     */
    public function className()
    {
        $class = get_class($this);
        $segments = explode('\\', $class);
        return $segments[count($segments)-1];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getDisconnectionTime()
    {
        return $this->disconnectionTime;
    }

    /**
     * @param int $disconnectionTime
     */
    public function setDisconnectionTime($disconnectionTime)
    {
        $this->disconnectionTime = $disconnectionTime;
    }

    /**
     * @param string $message
     */
    public function send($message)
    {
        if(!is_null($this->getConnexion())) {
            $this->getConnexion()->send($message);
        }
    }
}