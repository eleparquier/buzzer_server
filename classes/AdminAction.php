<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 03/08/15
 * Time: 14:03
 */

namespace fr\manaur\buzzer;


abstract class AdminAction extends Action
{
    /**
     * @var bool
     */
    protected $ok = true;

    /**
     * @return void
     */
    function action()
    {
        if(!isset($this->password)) {
            Serveur::getInstance()->log("Action d'admin tentée, pas de mot de passe");
            $this->ok = false;
        }

        if($this->password != Conf::getPassword() && $this->type != 'Reload') {
            Serveur::getInstance()->log("Action d'admin tentée, mauvais mot de passe");
            $this->ok = false;
        }
    }
}