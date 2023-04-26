<?php

declare(strict_types=1);

define('GRID', array_map(
	fn ($line) => str_split(strtoupper($line)),
	file('./input.txt', FILE_IGNORE_NEW_LINES)
));

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

function traverse(array $sizeMap = [], array $grid = GRID): array
{
	foreach ($grid as $y => $row) {
		foreach ($row as $x => $letter) {
			$sizeMap[$y][$x] = $height = $width = 1;

			while (checkLetter($y, $x + $width, $letter)) {
				$width++;
			}
			while (checkLetter($y + $height, $x, $letter)) {
				$height++;
			}

			$sizeMap[$y][$x] = $width * $height;

			if (($width > 1 && $height > 1 && isVowel($letter))) {
				echo "$letter ($x, $y) -> {$width}x{$height}"
					. PHP_EOL;
			}
		}
	}
	return $sizeMap;
}

function checkLetter(
	int $y,
	int $x,
	string $letter,
	array $grid = GRID
): bool {
	return isVowel($letter)
		&& isset($grid[$y][$x])
		&& $letter === $grid[$y][$x];
}

function checkLetters(int $y, int $x, array $grid = GRID)
{
	$vowels = [];
	while (
		isset($grid[$y][$x]) && isVowel($grid[$y][$x])
		&& (isset($grid[$y][$x - 1]) && $grid[$y][$x - 1] === $grid[$y][$x]
		|| isset($grid[$y][$x + 1]) && $grid[$y][$x + 1] === $grid[$y][$x])
	) {
		$vowels[] = $grid[$y][$x];
		$x++;
	}

	return $vowels;
}

function dd(...$var)
{
	var_dump(...$var);
	exit();
}

$sizeMap = traverse();
printGrid();
printGrid($sizeMap);
