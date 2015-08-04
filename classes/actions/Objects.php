<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 04/08/15
 * Time: 13:34
 */

namespace fr\manaur\buzzer;


class Objects extends AdminAction
{
    function action()
    {
        parent::action();
        if($this->ok) $this->sendFreeText(Serveur::getInstance());
    }
}