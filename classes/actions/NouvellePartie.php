<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:54
 */

namespace fr\manaur\buzzer;


class NouvellePartie extends Action
{
    /**
     * @throws \Exception
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->salonExists($this->idSalon)) {
            $salon = Serveur::getInstance()->getSalons()[$this->idSalon];
            $salon->lancerPartie();
        } else {
            throw new \Exception("Salon ".$this->idSalon." introuvable");
        }
    }
}