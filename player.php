<?php

require_once('functions/fCheckProbability.php');
require_once('functions/deciding.php');

class Player
{
    const VERSION = "2.3.1";

    public function betRequest($game_state)
    {
        error_log('betRequest:' . PHP_EOL . json_encode($game_state) . PHP_EOL);


    	// error_log(print_R(game_state, true));
    	foreach ($game_state['players'] as $p) {
    		if ($p['name'] == 'EnazaTeam') {
                $blindsCount = $p['stack'] / ($game_state['small_blind'] * 2);

                if ($blindsCount > 25) {
                    $limitPercent = 75;
                } elseif ($blindsCount > 12) {
                    $limitPercent = 60;
                } else {
                    $limitPercent = 50;
                }

				$card1 = $p['hole_cards'][0];
		    	$card2 = $p['hole_cards'][1];

		    	$result = fCheckProbability($card1['rank'], $card2['rank'], $card1['suit'] == $card2['suit']);

                error_log('card1:' . PHP_EOL . json_encode($card1) . PHP_EOL);
                error_log('card2:' . PHP_EOL . json_encode($card2) . PHP_EOL);
                error_log('$limitPercent:' . PHP_EOL . $limitPercent);

		    	return $result > $limitPercent ? 1000000 : 0;
    		}
    	}

    	return 1000000;
    }

    public function showdown($game_state)
    {
        error_log('showdown:' . PHP_EOL . json_encode($game_state) . PHP_EOL);
    }
}
