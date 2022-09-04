<?php

define("MATRIX" , convertFileToArray("input.txt"));
define("VOWELS" , ["A","E","I","O","U"]);

function convertFileToArray($file)
{
    $array = file_get_contents($file);
    $array = explode("\n", $array);
    return $array;
}

for ($y = 0; $y < count(MATRIX); $y++) {
    for ($x = 0; $x < strlen(MATRIX[$y]); $x++) {
        $letter = MATRIX[$y][$x];
        $results = findBlock($x, $y, $letter);
        var_dump($results);
    }
}

function sameLetter($a, $b)
{
    if ($a == $b) {
        return true;
    }
    return false;
}

function exists($width, $height, $x, $y)
{
    if (
        isset(MATRIX[$y + $height][$x + $width + 1]) &&
        isset(MATRIX[$y + $height + 1][$x + $width]) &&
        isset(MATRIX[$y + $height + 1][$x + $width + 1])
    ) {
        return true;
    }
    return false;
}

function findBlock($x, $y, $letter)
{
    $square = true;
    $width = 0;
    $height = 0;
    $combined = '';
    while ($square) {
        if (
            exists($width, $height, $x, $y) &&
            in_array($letter, VOWELS) &&
            sameLetter($letter, MATRIX[$y + $height][$x + $width + 1]) &&
            sameLetter($letter, MATRIX[$y + $height + 1][$x + $width]) &&
            sameLetter($letter, MATRIX[$y + $height + 1][$x + $width + 1])
        ) {
            $width++;
            $height++;
            $combined .= (
                $letter . 
                MATRIX[$y][$x + $width] .
                MATRIX[$y + $height][$x + $width] . 
                MATRIX[$y + $height][$x]
            );
            if (substr_count($combined, $letter) >= 4) { 
                echo $combined . PHP_EOL;
                $results[] = "($x,$y) : $letter";
                    return $results;
            }
        } else {
            $square = false;
        }
    }
    // foreach ($results as $pos => $letter) {
    //     echo "Match at ($pos) - $letter" . PHP_EOL;
    // }
}