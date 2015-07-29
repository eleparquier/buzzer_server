<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:56
 */

namespace fr\manaur\buzzer;


class Synchro extends Action
{
    /**
     * @throws \Exception
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->buzzerExists($this->idBuzzer)) {
            $buzzer = Serveur::getInstance()->getBuzzers()[$this->idBuzzer];
            $buzzer->getSynchro()->receive($this);
        } else {
            throw new \Exception("Buzzer ".$this->idBuzzer." introuvable");
        }
    }
}