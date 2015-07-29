<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 14:34
 */

namespace fr\manaur\buzzer;

class ConnectNewSalon extends Action
{
    /**
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        $salon = Serveur::getInstance()->getSalons()->addNewSalon($this->getConnexion());
        $this->response['idSalon'] = $salon->getId();
        $this->sendResponse();
    }

}