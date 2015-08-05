<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 05/08/15
 * Time: 13:44
 */

namespace fr\manaur\buzzer;


class Stats extends Action
{
    /**
     * @return void
     */
    function action()
    {
        $this->sendFreeText(json_encode(array('type'=>'stats','nbSalons'=>Serveur::getInstance()->getSalons()->count(),'nbBuzzers'=>Serveur::getInstance()->getBuzzers()->count())));
    }
}