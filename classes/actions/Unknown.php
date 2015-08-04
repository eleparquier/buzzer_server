<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 04/08/15
 * Time: 13:49
 */

namespace fr\manaur\buzzer;


class Unknown extends Action
{
    /**
     * @return void
     */
    function action()
    {
        Serveur::getInstance()->log('Action inconnue');
    }

}