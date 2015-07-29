<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:55
 */

namespace fr\manaur\buzzer;


class ConnectNewBuzzer extends Action
{
    /**
     * @return void
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        $buzzer = Serveur::getInstance()->getBuzzers()->addNewBuzzer($this->getConnexion());
        if($this->pseudo) $buzzer->setPseudo($this->pseudo);
        $this->response['idBuzzer'] = $buzzer->getId();
        $this->response['pseudo'] = $buzzer->getPseudoApparent();
        $this->sendResponse();
    }
}