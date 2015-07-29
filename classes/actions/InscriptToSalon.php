<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:56
 */

namespace fr\manaur\buzzer;


class InscriptToSalon extends Action
{
    /**
     * @throws \Exception
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->buzzerExists($this->idBuzzer) && Serveur::getInstance()->salonExists($this->idSalon)) {
            $buzzer = Serveur::getInstance()->getBuzzers()[$this->idBuzzer];
            $salon = Serveur::getInstance()->getSalons()[$this->idSalon];
            $salon->inscriptionBuzzer($buzzer);
        } else {
            throw new \Exception("Buzzer ".$this->idBuzzer." ou salon ".$this->idSalon." introuvables");
        }
    }
}