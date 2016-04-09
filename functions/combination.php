<?php

function combination($hCard1, $hCard2, $f1, $f2, $f3) {
  $countArr = array(
  	'hearts' => 0,
  	'spades' => 0,
  	'clubs' => 0,
  	'diamonds' => 0,
  );
  $countArr[$hCard1['suit']]++;
  $countArr[$hCard2['suit']]++;
  $countArr[$f1['suit']]++;
  $countArr[$f2['suit']]++;
  $countArr[$f3['suit']]++;

  $suitMaxCount = max($countArr);

  if ($suitMaxCount > 4) 
    return 'flash';

  if ($suitMaxCount > 3) 
    return 'flashDro';

  $rankCount = array(
  	'2' => 0,
  	'3' => 0,
  	'4' => 0,
  	'5' => 0,
  	'6' => 0,
  	'7' => 0,
  	'8' => 0,
  	'9' => 0,
  	'10' => 0,
  	'J' => 0,
  	'Q' => 0,
  	'K' => 0,
  	'A' => 0
  );

  $rankCount[$hCard1['rank']]++;
  $rankCount[$hCard2['rank']]++;
  $rankCount[$f1['rank']]++;
  $rankCount[$f2['rank']]++;
  $rankCount[$f3['rank']]++;

  $rankMaxCount = max($rankCount);
  if ($rankMaxCount > 2) {
    return "trips";
  }

  return false;
}