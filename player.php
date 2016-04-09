<?php

require_once('functions/fCheckProbability.php');
require_once('functions/deciding.php');

class Player
{
    const VERSION = "2.2";

    public function betRequest($game_state)
    {
    	// error_log(print_R(game_state, true));
    	foreach ($game_state['players'] as $p) {
    		if ($p['name'] == 'EnazaTeam') {
				$card1 = $p['hole_cards'][0];
		    	$card2 = $p['hole_cards'][1];

		    	$result = fCheckProbability($card1['rank'], $card2['rank'], $card1['suit'] == $card2['suit']);

		    	return $result > 70 ? 1000000 : 0;
    		}
    	}

    	return 1000000;
    }

    public function showdown($game_state)
    {
        error_log(json_encode($game_state));
    }
}
