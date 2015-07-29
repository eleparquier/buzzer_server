<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:55
 */

namespace fr\manaur\buzzer;


class NomSalon extends Action
{
    /**
     * @throws \Exception
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->salonExists($this->idSalon)) {
            $salon = Serveur::getInstance()->getSalons()[$this->idSalon];
            $salon->changerNom($this->nom);
        } else {
            throw new \Exception("Salon ".$this->idSalon." introuvable");
        }
    }
}