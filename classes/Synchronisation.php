<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 01/07/15
 * Time: 20:44
 */

namespace fr\manaur\buzzer;


class Synchronisation
{
    /**
     * @var Buzzer
     */
    private $buzzer = null;

    /**
     * @var int
     */
    private $nbEssais = 0;

    /**
     * @var float
     */
    private $plusCourt = 0;

    /**
     * @var float
     */
    private $decalage = 0;

    /**
     * Synchro constructor.
     * @param Buzzer $buzzer
     */
    public function __construct(Buzzer $buzzer)
    {
        $this->buzzer = $buzzer;
    }

    /**
     * Lance la synchronisation
     */
    public function send()
    {
        $msg = array('idConnection' => $this->buzzer->getConnectionId(), 'msgType'=>'synchro', 'error'=>0, 'errorMsg'=>'', 'timeSend'=>microtime(true));
        $this->buzzer->send(json_encode($msg));
    }

    /**
     * @param Synchro $msg
     */
    public function receive($msg)
    {
        $tps = (microtime(true) - $msg->timeSend) / 2;
        if($tps < $this->plusCourt || $this->plusCourt == 0) {
            $this->plusCourt = $tps;
            $this->decalage = microtime(true) - ($msg->timeCli/1000) - $tps;
        }
        $this->incrNbEssais();
        if($this->nbEssais < Conf::getNbEssaisSynchro()) {
            $this->send();
        } else {
            $this->getBuzzer()->setDecalage($this->decalage);
        }
    }

    /**
     * @return Buzzer
     */
    public function getBuzzer()
    {
        return $this->buzzer;
    }

    /**
     * @param Buzzer $buzzer
     */
    public function setBuzzer($buzzer)
    {
        $this->buzzer = $buzzer;
    }

    /**
     * @return int
     */
    public function getNbEssais()
    {
        return $this->nbEssais;
    }

    /**
     * @param int $nbEssais
     */
    public function setNbEssais($nbEssais)
    {
        $this->nbEssais = $nbEssais;
    }

    /**
     * incrément
     */
    public function incrNbEssais()
    {
        $this->nbEssais++;
    }


}