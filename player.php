<?php

require_once('functions/fCheckProbability.php');
require_once('functions/deciding.php');

class Player
{
    const VERSION = "2.3.10";

    public function betRequest($game_state)
    {
        error_log('betRequest:' . PHP_EOL . json_encode($game_state) . PHP_EOL);
        error_log('round: ' . $game_state['round'] . PHP_EOL . '---' . PHP_EOL);

        $allInCount = 0;
        foreach ($game_state['players'] as $p) {
            if ($p['name'] != 'EnazaTeam' && $p['status'] == 'active' && $p['stack'] <= $p['bet']) {
                $allInCount++;
            }
        }

        // foreach ($game_state['player'] as $p) {
        //     if ($p['status'] == 'active') {
        //         $playersCount+++;
        //     }
        // }

    	// error_log(print_R(game_state, true));
    	foreach ($game_state['players'] as $i => $p) {
    		if ($p['name'] == 'EnazaTeam') {
                $blindsCount = $p['stack'] / ($game_state['small_blind'] * 2);

                if ($blindsCount > 25) {
                    $limitPercent = 80;
                } elseif ($blindsCount > 12) {
                    $limitPercent = 75;
                } elseif ($blindsCount > 8) {
                    $limitPercent = 70;
                } else {
                    $limitPercent = 60;
                }

				$card1 = $p['hole_cards'][0];
		    	$card2 = $p['hole_cards'][1];

		    	$result = fCheckProbability($card1['rank'], $card2['rank'], $card1['suit'] == $card2['suit']);
          
                $playersCount = count($game_state['players']);
                $dealerIndex = ($game_state['dealer'] + 1) % $playersCount;
                $currentIndex = $i + 1;

                if ($dealerIndex < $currentIndex) {
                    $position = $currentIndex - $dealerIndex;
                } else {
                    $position = $playersCount - $dealerIndex + $currentIndex;
                }

                // if ($i == $p) {
                //     $position = $playersCount;
                // } else {
                //     if ($dealerIndex < $i) {
                //         $position = $i - $dealerIndex;
                //     } else {
                //         $position = $i + $playersCount - $dealerIndex;
                //     }
                // }
          
                $result2 = deciding($card1['rank'], $card2['rank'], $card1['suit'] == $card2['suit'], $position, $limpersCount = false, $raisersCount = false, $allInCount);

                error_log('card1:' . PHP_EOL . json_encode($card1) . PHP_EOL);
                error_log('card2:' . PHP_EOL . json_encode($card2) . PHP_EOL);
                error_log('$blindsCount:' . PHP_EOL . $blindsCount);
                error_log('$result:' . PHP_EOL . $result);
                error_log('$limitPercent:' . PHP_EOL . $limitPercent);
                error_log('$position:' . PHP_EOL . $position);
                error_log('$result2:' . PHP_EOL . $result2);
                error_log('$allInCount:' . PHP_EOL . $allInCount);

		    	if ($result > $limitPercent) {
                    return 1000000;
                } elseif ($position > 4 && $blindsCount > 10) {
                    return $game_state['small_blind'] * 4;
                } else {
                    return 0;
                }
    		}
    	}

    	return 1000000;
    }

    public function showdown($game_state)
    {
        error_log('showdown:' . PHP_EOL . json_encode($game_state) . PHP_EOL);
    }
}
