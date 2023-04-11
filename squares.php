<?php

declare(strict_types=1);

define('GRID', array_map(
	fn ($line) => str_split(strtoupper($line)),
	file('./input.txt', FILE_IGNORE_NEW_LINES)
));

function printGrid(array $grid = GRID): void
{
	echo ('  + 0 1 2 3 4 5 6 7 8 9 10 11' . PHP_EOL);
	array_walk($grid, fn ($rowLetters, $rowNum)
	=> printf("%2d: %s" . PHP_EOL, $rowNum, implode(' ', $rowLetters)));
}

function traverse(array $grid = GRID): void
{
	foreach ($grid as $y => $row) {
		foreach ($row as $x => $letter) {
			$height = $width = 1;

			while (compareLetter($y, $x + $width, $letter)) {
				$width++;
			}

			while (compareLetter($y + $height, $x, $letter)) {
				$height++;
			}
		}

		if (
			$width > 1
			/* && $height > 1 */
		) {
			echo ("{$grid[$y][$x]} ($x, $y) -> {$width}x{$width}" . PHP_EOL);
		}
	}
}

function findRepeatedVowelsInRow(array $rowLetters, int $y)
{
	foreach ($rowLetters as $x => $letter) {
		$width = 1;
		while (compareLetter($rowLetters, $x + $width - 2, $letter)) {
			$width++;
		}
		if ($width > 1) {
			printf('%s (%d, %d) -> %dx%d' . PHP_EOL, $letter, $x, $y, $width, 0);
		}
	}
}

function compareLetter(int $x, int $y, string $letter, array $grid = GRID): bool
{
	return in_array($letter, ['A', 'E', 'I', 'O', 'U'])
		&& isset($grid[$y][$x])
		&& $letter === $grid[$y][$x];
}

traverse();

printGrid();
