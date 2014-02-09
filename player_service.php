<?php

require_once('player.php');

$player = new Player();

switch($_POST['action'])
{
    case 'bet_request':
        echo $player->betRequest($_POST['game_state']);
        break;
}