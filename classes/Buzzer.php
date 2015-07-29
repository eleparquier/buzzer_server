<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 20/06/15
 * Time: 11:41
 */

namespace fr\manaur\buzzer;

class Buzzer extends Connected
{
    /**
     * @var Synchronisation
     */
    private $synchro;

    /**
     * Donne le nombre de secondes de retard du client par rapport au serveur.
     * Si le client est en avance : nombre négatif
     * @var float
     */
    private $decalage = 0;

    /**
     * @var float
     */
    private $dernierBuzz = 0;

    /**
     * @var Salon
     */
    private $salon = null;

    /**
     * @var string
     */
    private $pseudo = '';

    function __construct(Connexion $conn = null)
    {
        $this->synchro = new Synchronisation($this);
        parent::__construct($conn);
    }


    public function setConnexion($connexion)
    {
        parent::setConnexion($connexion);
    }

    /**
     * @return float
     */
    public function getDecalage()
    {
        return $this->decalage;
    }

    /**
     * @param float $decalage
     */
    public function setDecalage($decalage)
    {
        $this->decalage = $decalage;
    }

    /**
     * @return Synchronisation
     */
    public function getSynchro()
    {
        return $this->synchro;
    }

    /**
     * Lance la synchronisation
     */
    public function synchronize()
    {
        $this->synchro = new Synchronisation($this);
        $this->synchro->send();
    }

    public function __toString()
    {
        $ret = parent::__toString();
        $ret.= ' - decalage='.$this->decalage;
        return $ret;
    }

    /**
     * @return Salon
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * @param Salon $salon
     */
    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

    /**
     * Remet le salon à null
     */
    public function unsetSalon()
    {
        $this->salon = null;
    }

    /**
     * Supprime les références au salon et notifie les buzzers
     */
    public function remove()
    {
        if(!is_null($this->salon)) {
            $this->salon->desInscriptionBuzzer($this);
        }
    }

    /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @return string
     */
    public function getPseudoApparent()
    {
        if(!$this->pseudo) return $this->getId();
        else return $this->getPseudo();
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Envoie un buzz à la partie
     * @param string $time
     */
    public function buzz($time)
    {
        $this->dernierBuzz = (float) $time;
        if(!is_null($this->salon)) {
            $this->salon->receiveBuzz($this);
        }
    }

    /**
     * Notifie le pseudo de buzzer au salon et aux autres buzzers connectés au même salon
     */
    public function notifPseudo()
    {
        $msg = json_encode(array('idConnection' => $this->getConnectionId(), 'msgType'=>'changePseudo', 'error'=>0, 'errorMsg'=>'', 'idBuzzer'=>$this->getId(), 'pseudo'=>$this->getPseudoApparent()));
        if(!is_null($this->salon)) {
            $this->salon->send($msg);
            $this->salon->getBuzzers()->send($msg);
        }
    }

    /**
     * @return float
     */
    public function getDernierBuzz()
    {
        return $this->dernierBuzz;
    }

    /**
     * @param float $dernierBuzz
     */
    public function setDernierBuzz($dernierBuzz)
    {
        $this->dernierBuzz = $dernierBuzz;
    }


}