<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 03/08/15
 * Time: 13:56
 */

namespace fr\manaur\buzzer;


class Reload extends Action
{
    /**
     * @return void
     */
    function action()
    {
        Serveur::getInstance()->initConf();
    }

}