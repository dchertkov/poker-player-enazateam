<?php
require_once(dirname(__FILE__) . "/fCheckProbability.php");

// общий фактор агрессии, 1 - без корректировок
$aggressionFactor = 1;

// фактор увеличения важности позиции, за одну позицию
$positionFactor = 1.01;

// фактор страха лимперов, уменьшает процент успешного олина за каждого лимпера
$limpersFactor = 0.99;

// фактор страха рейзеров, уменьшает процент успешного олина за каждого рейзера
$raisersFactor = 0.95;

// значение параметра false = игнорировать
function deciding($card1, $card2, $isSuited, $position = false, $limpersCount = false, $raisersCount = false, $allInCount = false) {
	global $aggressionFactor, $positionFactor, $limpersFactor, $raisersFactor;

	// количество противников, если есть олинщики, считаем от их количества, если нет, считаем для одного
	$enemyCount = $allInCount ? $allInCount : 1;

	// считаем базовую вероятность против количества 100% - противников на флопе
	$baseProbability = fCheckProbability($card1, $card2, $isSuited, $enemyCount);

	// echo "Базовая вероятность для $enemyCount соперников $baseProbability \n";

	// увеличиваем вероятность из-за позиции, если есть
	if ($position) {
		for ($i = 1; $i <= $position; $i++) {
			$baseProbability = $baseProbability * $positionFactor;
		}
	}

	// уменьшаем вероятность из-за лимперов, если есть
	if ($limpersCount) {
		for ($i = 1; $i <= $limpersCount; $i++) {
			$baseProbability = $baseProbability * $limpersFactor;
		}
	}

	// уменьшаем вероятность из-за рейзеров, если есть
	if ($raisersCount) {
		for ($i = 1; $i <= $raisersCount; $i++) {
			$baseProbability = $baseProbability * $raisersFactor;
		}
	}

	// echo "Вероятность с учетом других факторов $baseProbability \n";

	$baseProbability = $baseProbability * $aggressionFactor;

	return $baseProbability;
}

// deciding("A", "K", false, 4, 5, 1);