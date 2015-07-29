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
        if(isset(Serveur::getInstance()->getBuzzers()->buzzers[$this->idBuzzer])) {
            $buzzer = Serveur::getInstance()->getBuzzers()->buzzers[$this->idBuzzer];
            $buzzer->setConnexion($this->getConnexion());
        } else {
            $buzzer = Serveur::getInstance()->getBuzzers()->addNewBuzzer($this->getConnexion());
        }
        $this->response['idBuzzer'] = $buzzer->getId();
        $this->sendResponse();
    }
}