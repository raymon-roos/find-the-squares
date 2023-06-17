<?php

declare(strict_types=1);

define('GRID', array_map(
	fn ($line) => str_split(strtoupper($line)),
	file('./input.txt', FILE_IGNORE_NEW_LINES)
));

function traverse(): array
{
	foreach (GRID as $y => $row) {
		foreach ($row as $x => $letter) {
			[$sizeMap[$y][$x], $width, $height]
				= findRectangleSize($y, $x, $letter);

			if (isOutermostRectangle($y, $x, $sizeMap)) {
				echo "$letter ($x, $y) -> {$width}x{$height}"
					. PHP_EOL;
			}
		}
	}

	// Traverse doesn't actually need to return its internal representation of
	// detected rectangles, but I left it in to help elucidate the functioning
	// of this "algorithm"
	return $sizeMap;
}

function findRectangleSize(int $y, int $x, string $letter): array
{
	$maxWidth = $width = $repeatedVowels = $height = 0;

	while (isRepeatedVowel($y + $height, $x, $letter)) {
		while (isRepeatedVowel($y + $height, $x + $width, $letter)) {
			$width++;
			$repeatedVowels++;
		}
		if ($width > $maxWidth) {
			$maxWidth = $width;
		}
		$width = 0;
		$height++;
	}

	return [$repeatedVowels, $maxWidth, $height];
}

function isOutermostRectangle(int $y, int $x, array $sizeMap,): bool
{
	$biggerThenPrevious = $sizeMap[$y][$x] >= 4;

	if (isset($sizeMap[$y][$x - 1])) {
		$biggerThenPrevious = $biggerThenPrevious
			&& $sizeMap[$y][$x] > $sizeMap[$y][$x - 1];
	}

	if (isset($sizeMap[$y - 1][$x])) {
		$biggerThenPrevious = $biggerThenPrevious
			&& $sizeMap[$y][$x] > $sizeMap[$y - 1][$x];
	}

	if (isset($sizeMap[$y - 1][$x - 1])) {
		$biggerThenPrevious = $biggerThenPrevious
			&& $sizeMap[$y][$x] > $sizeMap[$y - 1][$x - 1];
	}

	return $biggerThenPrevious;
}

function isRepeatedVowel(int $y, int $x, string $letter): bool
{
	return isVowel($letter)
		&& isset(GRID[$y][$x])
		&& $letter === GRID[$y][$x];
}

function isVowel(string $letter): bool
{
	return in_array($letter, ['A', 'E', 'I', 'O', 'U']);
}

function printGrid(array $grid = GRID): void
{
	echo '  + 0 1 2 3 4 5 6 7 8 9 10 11' . PHP_EOL;
	array_walk($grid, fn ($rowLetters, $rowNum)
	=> printf("%2d: %s" . PHP_EOL, $rowNum, implode(' ', $rowLetters)));
}

function dd(...$args)
{
	var_dump(...$args);
	exit();
}

$sizeMap = traverse();

// Uncomment these to see more of what's going on:
// printGrid();
// printGrid($sizeMap);
