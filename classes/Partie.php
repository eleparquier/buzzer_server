<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 17/07/15
 * Time: 22:45
 */

namespace fr\manaur\buzzer;


class Partie
{
    /**
     * @var Salon
     */
    private $salon;

    /**
     * @var bool
     */
    private $pause = false;

    /**
     * Le gagnant actuel de la partie
     * @var Buzzer
     */
    private $gagnant = null;

    /**
     * @param Salon $salon
     */
    function __construct(Salon $salon)
    {
        $this->salon = $salon;
    }

    /**
     * @param Buzzer $buzzer
     */
    function receiveBuzz(Buzzer $buzzer) {
        $this->setPause(true);
        if(is_null($this->gagnant) || $buzzer->getDernierBuzz() + $buzzer->getDecalage() < $this->gagnant->getDernierBuzz() + $this->gagnant->getDecalage()) {
            $this->setGagnant($buzzer);
            $this->notifGagnant();
        }
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
     * @return boolean
     */
    public function isPause()
    {
        return $this->pause;
    }

    /**
     * @param boolean $pause
     */
    public function setPause($pause)
    {
        $this->pause = $pause;
    }

    /**
     * @return Buzzer
     */
    public function getGagnant()
    {
        return $this->gagnant;
    }

    /**
     * @param Buzzer $gagnant
     */
    public function setGagnant($gagnant)
    {
        $this->gagnant = $gagnant;
    }

    /**
     * Remet le gagnant à null
     */
    public function resetGagnant()
    {
        $this->gagnant = null;
    }

    /**
     * Notifie le salon et ses buzzers de qui a gagné
     */
    public function notifGagnant()
    {
        $msg = json_encode(array('msgType'=>'notifGagnant', 'error'=>0, 'errorMsg'=>'', 'idSalon' => $this->getSalon()->getId(), 'idBuzzer'=>$this->getGagnant()->getId(), 'time'=>$this->getGagnant()->getDernierBuzz() + $this->getGagnant()->getDecalage(), 'pseudo'=>$this->getGagnant()->getPseudoApparent()));
        $this->getSalon()->send($msg);
        $this->getSalon()->getBuzzers()->send($msg);
    }


}