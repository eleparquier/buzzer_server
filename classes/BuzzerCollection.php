<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 22/06/15
 * Time: 13:28
 */

namespace fr\manaur\buzzer;


class BuzzerCollection extends BaseCollection
{
    /**
     * @param Buzzer $buzzer
     */
    public function ajout(Buzzer $buzzer)
    {
        $this[$buzzer->getId()] = $buzzer;
    }

    /**
     * @param Connexion $connexion
     * @return Buzzer
     */
    public function addNewBuzzer(Connexion $connexion)
    {
        $buzzer = new Buzzer($connexion);
        Serveur::getInstance()->getIndex()->addConnected($buzzer);
        $this[$buzzer->getId()] = $buzzer;
        return $buzzer;
    }

    /**
     * Remet à 0 les dernier buzz de tous les buzzers de la collection
     */
    public function resetDernierBuzz()
    {
        foreach($this as $buzzer) {/** @var Buzzer $buzzer */
            $buzzer->setDernierBuzz(0);
        }
    }
}