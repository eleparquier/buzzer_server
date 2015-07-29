<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 22/06/15
 * Time: 17:16
 */

namespace fr\manaur\buzzer;

class Index
{
    /**
     * Index des objets Connected resourceId=>Connected
     * @var array
     */
    private $connecteds = array();

    /**
     * Index des Connexions en cours resourceId=>Connexion
     * @var array
     */
    private $connections = array();


    /**
     * Dit si une Connexion est associée à un salon ou un buzzer
     * @param int $id
     * @return boolean
     */
    public function isAssociated($id)
    {
        if(!isset($this->connections[$id])) return false;
        return isset($this->connecteds[$this->connections[$id]]);
    }

    /**
     * Renvoie un Connected à partir du resourceId de sa connection
     * @param int $id
     * @return Connected
     */
    public function getConnectedByIdRessouce($id)
    {
        if(!isset($this->connections[$id])) return null;
        return $this->connecteds[$this->connections[$id]->getRessourceId()];
    }

    /**
     * Dit si une connection est active
     * @param int $id
     * @return boolean
     */
    public function isConnected($id) {
        return isset($this->connections[$id]);
    }

    /**
     * Renvoie une Connexion à partir du resourceId
     * @param int $id
     * @return Connexion
     */
    public function getById($id)
    {
        return $this->connections[$id];
    }

    /**
     * Ajoute une connection à l'index
     * @param Connexion $conn
     */
    public function addConnection(Connexion $conn)
    {
        $this->connections[$conn->getRessourceId()] = $conn;
    }

    /**
     * Retire une connection de l'index
     * @param Connexion $conn
     */
    public function removeConnection(Connexion $conn)
    {
        unset($this->connections[$conn->getRessourceId()]);
    }

    /**
     * Retire une connection de l'index
     * @param int $id ResourceId de la connexion
     */
    public function removeConnectionById($id)
    {
        unset($this->connections[$id]);
    }

    /**
     * Ajoute un Connected à l'index
     * @param Connected $conn
     */
    public function addConnected(Connected $conn)
    {
        $this->connecteds[$conn->getId()] = $conn;
    }

    /**
     * Retire un Connected de l'index
     * @param Connected $conn
     */
    public function removeConnected(Connected $conn)
    {
        unset($this->connecteds[$conn->getId()]);
    }

    /**
     * Retire un Connected de l'index
     * @param int $id
     */
    public function removeConnectedById($id)
    {
        unset($this->connecteds[$id]);
    }

    public function __toString()
    {
        $ret = '';
        foreach($this->connecteds as $index=>$connected) {
            $ret .= 'index='.$index.' => '.$connected."\n";
        }
        $ret .= "Connections ------ \n";
        foreach($this->connections as $index=>$connection) {
            $ret .= 'index='.$index.' => '.$connection."\n";
        }
        return $ret;
    }

}