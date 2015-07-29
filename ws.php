#!/usr/bin/php
<?php
use Ratchet\Server\IoServer;

require dirname(__FILE__) . '/vendor/autoload.php';
require dirname(__FILE__) . '/classes/Serveur.php';

require dirname(__FILE__) . '/classes/ActionFactory.php';
require dirname(__FILE__) . '/classes/Action.php';
require dirname(__FILE__) . '/classes/actions/Buzz.php';
require dirname(__FILE__) . '/classes/actions/ConnectNewSalon.php';
require dirname(__FILE__) . '/classes/actions/ConnectNewBuzzer.php';
require dirname(__FILE__) . '/classes/actions/DesInscriptFromSalon.php';
require dirname(__FILE__) . '/classes/actions/InscriptToSalon.php';
require dirname(__FILE__) . '/classes/actions/NomSalon.php';
require dirname(__FILE__) . '/classes/actions/NouvellePartie.php';
require dirname(__FILE__) . '/classes/actions/Pseudo.php';
require dirname(__FILE__) . '/classes/actions/ReconnectBuzzer.php';
require dirname(__FILE__) . '/classes/actions/ReconnectSalon.php';
require dirname(__FILE__) . '/classes/actions/RecupSalons.php';
require dirname(__FILE__) . '/classes/actions/RefreshAutresBuzzers.php';
require dirname(__FILE__) . '/classes/actions/RelancePartie.php';
require dirname(__FILE__) . '/classes/actions/StartSynchro.php';
require dirname(__FILE__) . '/classes/actions/Synchro.php';

require dirname(__FILE__) . '/classes/Partie.php';
require dirname(__FILE__) . '/classes/Synchronisation.php';
require dirname(__FILE__) . '/classes/Numerotation.php';
require dirname(__FILE__) . '/classes/BaseCollection.php';
require dirname(__FILE__) . '/classes/Connected.php';
require dirname(__FILE__) . '/classes/Connexion.php';
require dirname(__FILE__) . '/classes/SalonCollection.php';
require dirname(__FILE__) . '/classes/BuzzerCollection.php';
require dirname(__FILE__) . '/classes/Buzzer.php';
require dirname(__FILE__) . '/classes/Salon.php';
require dirname(__FILE__) . '/classes/Index.php';



$noyau = new \fr\manaur\buzzer\Serveur();

$server = IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            $noyau
        )
    ),
    30572
);

$noyau->setLoop($server->loop);

$server->run();

