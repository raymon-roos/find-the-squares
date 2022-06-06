<?php

define("MATRIX" , convertFileToArray("./input.txt"));
$testArray = MATRIX;
define("VOWELS" , ["A","E","I","O","U"]);

function convertFileToArray($file)
{
    $array = explode("\n", file_get_contents($file));
    foreach ($array as $row => $str) {
        $array[$row] = str_split($str);
    } 
    return $array;
}

function ditchConsonants(&$letter)
{
    if (!in_array($letter, VOWELS)) {
        $letter = '';
    }
}

function analyzeArray($array)
{
    foreach ($array as $rowNum => $letters) {
        foreach ($letters as $letter) {
        }
    }
    return $results;
}

function printResults($results)
{
    foreach ($results as $pos => $letter) {
        echo "Match at ($pos) - $letter" . PHP_EOL;
    }
}

array_walk_recursive($testArray, 'ditchConsonants');

foreach ($testArray as $row => $letter) {
    var_dump(array_filter($letter)); 
}


// printResults(analyzeArray());

