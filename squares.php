<?php

declare(strict_types=1);

define('VOWELS', ['A', 'E', 'I', 'O', 'U']);
define('MATRIX', array_map(
	fn ($line) => str_split(strtoupper($line)), // Guarantee each letter is uppercase
	explode("\n", file_get_contents('./input.txt'))
));

function printMatrix(): void
{
	echo ('  + 0 1 2 3 4 5 6 7 8 9 10 11' . PHP_EOL);
	foreach (MATRIX as $rowNum => $rowLetters) {
		// Prefix an empty space if the linenumber has less than two digits
		echo ((($rowNum < 10) ? ' ' : '') .  $rowNum . ': ' . implode(' ', $rowLetters) . PHP_EOL);
	}
}

function traverse(array $matrix = MATRIX)
{
	return array_map('findRepeatedVowelsInRow', $matrix);
}

function findRepeatedVowelsInRow(array $row): array
{
	$vowelsFoundInRow = [];

	foreach ($row as $colNum => $letter) {
		if (
			compareNextLetter($row, $colNum, $letter) ||  // Checking both forwards and backwards is necessary, otherwise 
			comparePreviousLetter($row, $colNum, $letter) // the third A in AAAB won't be detected considering A !== B. 
		) {
			$vowelsFoundInRow += [$colNum => $letter];
		}
	}

	return $vowelsFoundInRow;
}

function comparePreviousLetter(array $row, int $pos, string $letter): bool
{
	return in_array($letter, VOWELS)
		&& isset($row[$pos - 1])
		&& $letter === $row[$pos - 1];
}

function compareNextLetter(array $row, int $pos, string $letter): bool
{
	return in_array($letter, VOWELS)
		&& isset($row[$pos + 1])
		&& $letter === $row[$pos + 1];
}

printMatrix();
echo PHP_EOL;
print_r(traverse()); // every letter is keyed to its original horizontal coördinate
echo PHP_EOL;
print_r(array_map('implode', traverse()));
