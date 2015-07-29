<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 20/06/15
 * Time: 11:38
 */

namespace fr\manaur\buzzer;

use Ratchet\ConnectionInterface;

class Connexion
{
    /**
     * @var ConnectionInterface
     */
    private $connexion;

    /**
     * @var Connected
     */
    private $connected;

    /**
     * Connexion constructor.
     * @param ConnectionInterface $connexion
     */
    public function __construct(ConnectionInterface $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnexion()
    {
        return $this->connexion;
    }

    /**
     * @param ConnectionInterface $connexion
     */
    public function setConnexion(ConnectionInterface $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * @return int
     */
    public function getRessourceId() {
        return $this->connexion->resourceId;
    }

    public function __toString()
    {
        return "ResourceId=".$this->getRessourceId();
    }

    /**
     * Événement sur déconnexion du client
     */
    public function onDisconnect()
    {
        if(!is_null($this->getConnected())) $this->getConnected()->onDisconnect();
    }

    /**
     * @return Connected
     */
    public function getConnected()
    {
        return $this->connected;
    }

    /**
     * @param Connected $connected
     */
    public function setConnected($connected)
    {
        $this->connected = $connected;
    }

    /**
     * @param array $msg
     */
    public function send($msg)
    {
        $this->connexion->send($msg);
        Serveur::getInstance()->log('>#' . $this->getRessourceId() . ' - ' . $msg);
    }
}