<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 22/06/15
 * Time: 13:28
 */

namespace fr\manaur\buzzer;

class SalonCollection extends BaseCollection
{
    /**
     * @param Salon $salon
     */
    public function ajout(Salon $salon)
    {
        $this[$salon->getId()] = $salon;
    }

    /**
     * @param Connexion $connexion
     * @return Salon
     */
    public function addNewSalon(Connexion $connexion)
    {
        $salon = new Salon($connexion);
        Serveur::getInstance()->getIndex()->addConnected($salon);
        $this[$salon->getId()] = $salon;
        return $salon;
    }
}