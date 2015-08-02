<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:55
 */

namespace fr\manaur\buzzer;


class ReconnectBuzzer extends Action
{
    /**
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->buzzerExists($this->idBuzzer)) {
            $buzzer = Serveur::getInstance()->getBuzzers()[$this->idBuzzer];
            $buzzer->setConnexion($this->getConnexion());
        } else {
            $buzzer = Serveur::getInstance()->getBuzzers()->addNewBuzzer($this->getConnexion());
        }
        $this->response['idBuzzer'] = $buzzer->getId();
        if(!is_null($buzzer->getSalon())) {
            $this->response['idSalon'] = $buzzer->getSalon()->getId();
            $this->response['partieEnCours'] = $buzzer->getSalon()->partieEnCours();
            $this->response['partieEnPause'] = $buzzer->getSalon()->partieEnPause();
        }
        $this->sendResponse();
    }
}