<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 27/07/15
 * Time: 14:27
 */

namespace fr\manaur\buzzer;

class ActionFactory
{
    /**
     * Renvoie un objet du type précisé dans le champ msgType de $source
     * @param \StdClass $source
     * @param Connexion $connexion
     * @return Action
     */
    public static function make(\StdClass $source, Connexion $connexion){
        $class = __NAMESPACE__.'\\'.ucfirst($source->type);
        if(in_array(ucfirst($source->type),Serveur::getInstance()->getActions())) {
            $ret = new $class($source);
        } else {
            $ret = new Unknown($source);
        }
        /** @var Action $ret */
        $ret->setConnexion($connexion);
        $ret->setResponse(array('idConnection'=>$connexion->getRessourceId(),'msgType'=>$source->type, 'error'=>0, 'errorMsg'=>''));
        return $ret;
    }
}