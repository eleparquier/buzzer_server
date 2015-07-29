<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 17/03/15
 * Time: 11:00
 */

namespace fr\manaur\buzzer;

class BaseCollection extends \ArrayObject{

    public function __toString()
    {
        $ret = "Nb=".$this->count()."\n";
        foreach($this as $index=>$elem) {
            $ret .= 'index=>'.$index.'=>'.$elem."\n";
        }
        return $ret;
    }

    /**
     * Envoie un message à tous les Connecteds de la collection
     * @var string $msg
     */
    public function send($msg)
    {
        foreach($this as $id=>$connected) {/** @var Connected $connected */
            $connected->send($msg);
        }
    }
}