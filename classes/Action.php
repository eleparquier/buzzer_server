<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 13:47
 */

namespace fr\manaur\buzzer;


abstract class Action
{
    /**
     * @var Connexion
     */
    private $connexion = null;

    /**
     * @var array
     */
    protected $response = array();

    public function __construct(\stdClass $source)
    {
        foreach($source as $prop=>$value) {
            $this->$prop = $value;
        }
    }

    /**
     * @return void
     */
    abstract function action();

    public function __get($prop)
    {
        return $this->$prop;
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
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * Envoie la réponse à la connexion
     */
    public function sendResponse()
    {
        $this->getConnexion()->send(json_encode($this->response));
    }

}