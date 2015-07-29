<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:56
 */

namespace fr\manaur\buzzer;


class RecupSalons extends Action
{
    /**
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        $this->response['idSalons'] = array();
        foreach(Serveur::getInstance()->getSalons() as $salon) {
            $this->response['idSalons'][$salon->getId()] = $salon->getNomApparent();
        }
        $this->sendResponse();
    }
}