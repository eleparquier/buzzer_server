<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:54
 */

namespace fr\manaur\buzzer;


class ReconnectSalon extends Action
{
    /**
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */

        if(Serveur::getInstance()->salonExists($this->idSalon)) {
            $salon = Serveur::getInstance()->getSalons()[$this->idSalon];
            $salon->setConnexion($this->getConnexion());
            $this->response['idSalon'] = $salon->getId();
        } else {
            $this->response['error'] = 1;
            $this->response['errorMsg'] = "Salon introuvable, un salon va être recréé.";
        }
        $this->sendResponse();
    }
}