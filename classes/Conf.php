<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 03/08/15
 * Time: 13:38
 */

namespace fr\manaur\buzzer;


class Conf
{
    /**
     * @var int
     */
    private static $delayBetweenCleaning = null;

    /**
     * @var int
     */
    private static $maxDeconnexionTime = null;

    /**
     * @var int
     */
    private static $nbEssaisSynchro = null;

    /**
     * Initialisation des variables à partir du fichier de conf
     */
    public static function init(){
        foreach(parse_ini_file(dirname(__FILE__).'/../conf/conf.ini') as $var=>$val) {
            self::$$var = (int) $val;
        }
    }

    /**
     * @return int
     */
    public static function getDelayBetweenCleaning()
    {
        return self::$delayBetweenCleaning;
    }

    /**
     * @return int
     */
    public static function getMaxDeconnexionTime()
    {
        return self::$maxDeconnexionTime;
    }

    /**
     * @return int
     */
    public static function getNbEssaisSynchro()
    {
        return self::$nbEssaisSynchro;
    }


}