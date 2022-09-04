<?php

define("MATRIX" , convertFileToArray("./input.txt"));
define("VOWELS" , ["A","E","I","O","U"]);

function convertFileToArray($file)
{
    $array = explode("\n", file_get_contents($file));
    foreach ($array as $row => $str) {
        $array[$row] = str_split($str);
    } 
    return $array;
}

function traverse(): void
{
    $row = 0; 
    while ($row < count(MATRIX) - 1) { 
        echo(MATRIX[$row] . PHP_EOL);
        $col = 0; 
        while ($col < count(MATRIX[$row]) - 1) { 
            echo(MATRIX[$row][$col] . ' ');

            if (isVowel(MATRIX[$row][$col])) {
                if (compareAhead($row, $col)) {
                    $col++;
                } elseif (compareDown($row, $col)) {
                    $row++;
                }
            }
        }
    }
}

function isVowel(string $letter): bool
{
    return in_array($letter, VOWELS);
}

function compareAhead(int $row, int $col)
{
    return MATRIX[$row][$col] == MATRIX[$row][$col + 1];
}

function compareDown(int $row, int $col)
{
    return MATRIX[$row][$col] == MATRIX[$row + 1][$col];
}

traverse();
