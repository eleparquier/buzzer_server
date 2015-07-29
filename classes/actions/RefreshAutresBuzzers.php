<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 16:56
 */

namespace fr\manaur\buzzer;


class RefreshAutresBuzzers extends Action
{
    /**
     * @throws \Exception
     */
    function action()
    {
        /** @var Salon $salon */
        /** @var Buzzer $buzzer */
        if(Serveur::getInstance()->buzzerExists($this->idBuzzer) && Serveur::getInstance()->salonExists($this->idSalon)) {
            $buzzer = Serveur::getInstance()->getBuzzers()[$this->idBuzzer];
            $salon = Serveur::getInstance()->getSalons()[$this->idSalon];
            foreach($salon->getBuzzers() as $buz) {
                if($buz->getId() != $buzzer->getId()) {
                    $buzzer->send(json_encode(array('idConnection' => $buzzer->getConnectionId(), 'msgType'=>'inscriptToSalon', 'error'=>0, 'errorMsg'=>'', 'idSalon'=>$salon->getId(), 'idBuzzer'=>$buz->getId(), 'pseudo'=>$buz->getPseudoApparent())));
                }
            }
        } else {
            throw new \Exception("Buzzer ".$this->idBuzzer." ou salon ".$this->idSalon." introuvables");
        }
    }
}