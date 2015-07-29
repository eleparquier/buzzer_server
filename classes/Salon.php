<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 20/06/15
 * Time: 11:41
 */

namespace fr\manaur\buzzer;

class Salon extends Connected
{
    /**
     * Les buzzers inscrits à ce salon
     * @var BuzzerCollection
     */
    private $buzzers =  null;

    /**
     * @var Partie
     */
    private $partie = null;

    /**
     * @var string
     */
    private $nom = '';

    function __construct(Connexion $conn = null)
    {
        parent::__construct($conn);
        $this->buzzers = new BuzzerCollection();
    }

    /**
     * Inscrit un buzzer au salon
     * @param Buzzer $buzzer
     */
    public function inscriptionBuzzer(Buzzer $buzzer)
    {
        if(!isset($this->buzzers[$buzzer->getId()])) {
            $this->buzzers->ajout($buzzer);
            $rep = array('idConnection' => $buzzer->getConnectionId(), 'msgType'=>'inscriptToSalon', 'error'=>0, 'errorMsg'=>'', 'idSalon'=>$this->getId(), 'idBuzzer'=>$buzzer->getId(), 'pseudo'=>$buzzer->getPseudoApparent(), 'partieEnCours'=>$this->partieEnCours(), 'partieEnPause'=>$this->partieEnPause());
            $this->buzzers->send(json_encode($rep));
            $this->send(json_encode($rep));
            if(!is_null($buzzer->getSalon())) $buzzer->getSalon()->desInscriptionBuzzer($buzzer);
            $buzzer->setSalon($this);
        }
    }

    /**
     * @return bool
     */
    public function partieEnCours()
    {
        if(is_null($this->partie)) return false;
        return true;
    }

    /**
     * @return bool
     */
    public function partieEnPause()
    {
        if(is_null($this->partie)) return true;
        return $this->getPartie()->isPause();
    }

    /**
     * @param Buzzer $buzzer
     * @param boolean $notifyBuzzers
     */
    public function desInscriptionBuzzer(Buzzer $buzzer, $notifyBuzzers = true)
    {
        $this->send($this->msgDesinscription($buzzer));
        if($notifyBuzzers) $this->buzzers->send($this->msgDesinscription($buzzer));
        unset($this->buzzers[$buzzer->getId()]);
        $buzzer->unsetSalon();
    }

    /**
     * @param Buzzer $buzzer
     * @return string
     */
    public function msgDesinscription(Buzzer $buzzer)
    {
        return json_encode(array('idConnection' => $buzzer->getConnectionId(), 'msgType'=>'desInscriptFromSalon', 'error'=>0, 'errorMsg'=>'', 'idSalon'=>$this->getId(), 'idBuzzer'=>$buzzer->getId()));
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
     * Notifie les buzzers de la suppression du salon
     */
    public function remove()
    {
        $buzzers = clone $this->buzzers;
        foreach($buzzers as $buzzer) {/** @var Buzzer $buzzer */
            $buzzer->send(json_encode(array('idConnection' => $buzzer->getConnectionId(), 'msgType'=>'suppressionSalon', 'error'=>0, 'errorMsg'=>'', 'idSalon'=>$this->getId(), 'idBuzzer'=>$buzzer->getId())));
            $this->desInscriptionBuzzer($buzzer, false);
            $buzzer->send($this->msgDesinscription($buzzer));
        }
    }

    /**
     * Commence une nouvelle partie
     */
    public function lancerPartie()
    {
        $this->buzzers->resetDernierBuzz();
        $this->partie = new Partie($this);
        $msg = json_encode(array('idConnection' => $this->getConnectionId(), 'msgType'=>'nouvellePartie', 'error'=>0, 'errorMsg'=>'', 'idSalon' => $this->getId()));
        $this->send($msg);
        $this->buzzers->send($msg);
    }

    /**
     * Relance partie
     */
    public function relancerPartie()
    {
        $this->partie->setPause(false);
        $this->partie->resetGagnant();
        $msg = json_encode(array('idConnection' => $this->getConnectionId(), 'msgType'=>'relancePartie', 'error'=>0, 'errorMsg'=>'', 'idSalon' => $this->getId()));
        $this->send($msg);
        $this->buzzers->send($msg);
    }

    /**
     * @return Partie
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * @param Partie $partie
     */
    public function setPartie($partie)
    {
        $this->partie = $partie;
    }

    /**
     * Traite la réception d'un buzz
     * @param Buzzer $buzzer
     */
    public function receiveBuzz(Buzzer $buzzer)
    {
        if(!is_null($this->partie)) {
            $this->partie->receiveBuzz($buzzer);
        }
    }

    /**
     * @return string
     */
    public function getNomApparent()
    {
        if(!$this->nom) return $this->getId();
        else return $this->getNom();
    }

    /**
     * @param string $nom
     */
    public function changerNom($nom)
    {
        $this->setNom($nom);
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

}