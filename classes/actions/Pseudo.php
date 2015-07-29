<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:55
 */

namespace fr\manaur\buzzer;


class Pseudo extends Action
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
            $buzzer->setPseudo($this->pseudo);
            $buzzer->notifPseudo();
        } else {
            throw new \Exception("Buzzer ".$this->idBuzzer." introuvable");
        }
    }
}