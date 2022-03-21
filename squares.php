<?php

define("MATRIX" , convertFileToArray("input.txt"));
define("VOWELS" , ["A","E","I","O","U"]);
$square[] = "";

function convertFileToArray($file)
{
    $array = file_get_contents($file);
    $array = explode("\n", $array);
    return $array;
}

function compareArray(&$square)
{
    foreach (MATRIX as $row) {
        $strHits = "";
        for ($i = 0; $i < strlen($row) - 1; $i++) {
            foreach (VOWELS as $vowel) {
                if ($row[$i] == $vowel) {
                    $strHits .= $row[$i];
                }
            }
        }
        array_push($square, $strHits);
    }
    print_r($square);
}

function isSquare($square)
{
    echo ("Vierkanten gevonden op: " . PHP_EOL);
    foreach ($square as $row) {
        if ($row[$i][$l] == $square[$i + 1][0]) { 
            echo ($square[$i][0] . ": (" . $square[$i][1] . "," . $i . ")" . PHP_EOL);
        }
    }
}

print_r(MATRIX);
compareArray($square);
// isSquare($square);

