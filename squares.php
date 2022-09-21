<?php

declare(strict_types=1);

define('MATRIX' , convertFileToArray('./input.txt'));
define('VOWELS' , ['A','E','I','O','U']);

function convertFileToArray(string $fileName): array
{
    $arrayFromFile = explode("\n", file_get_contents($fileName));
    foreach ($arrayFromFile as $row => $str) {
        $arrayFromFile[$row] = str_split($str);
    } 
    return $arrayFromFile;
}

function traverse(): void
{
    for ($row = 0; $row < count(MATRIX); $row++) { 
        for ($col = 0; $col < count(MATRIX[$row]); $col++) { 
	    if (isVowel(MATRIX[$row][$col])) {
		if (findSquare($col, $row, MATRIX[$row][$col])) {
		    $result[] = findSquare($col, $row, MATRIX[$row][$col]);
		}
            }
	}
    }
}

function findSquare(int $col, int $row, string $currentLetter): array | false
{
    $width = findWidth($row, $col);
    $heigth = findHeigth($row, $col);

    if ($width > 1 && $heigth > 1) {
	return [$currentLetter, $col, $row, $width, $heigth]; 
    }
    return false;
}

function findWidth(int $row, int $col): int
{
    $width = 0;
    while (compareAhead($row, $col)) {
     	$width++;
    }

    return $width;
}

function findHeigth(int $row, int $col): int
{
    $heigth = 0;
    while (compareDown($row, $col)) {
	$heigth++;
    }

    return $heigth;
}

function isVowel(string $letter): bool
{
    return in_array($letter, VOWELS);
}

function compareAhead(int $row, int $col): bool
{
    if (!isset(MATRIX[$row][$col + 1])) {
	return false;
    }
    return MATRIX[$row][$col] == MATRIX[$row][$col + 1];
}

function compareDown(int $row, int $col): bool
{
    if (!isset(MATRIX[$row + 1][$col])) {
	return false;
    }
    return MATRIX[$row][$col] == MATRIX[$row + 1][$col];
}

traverse();
var_dump($results);
