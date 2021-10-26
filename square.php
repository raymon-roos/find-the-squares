<?php

define("MATRIX" , convertFileToArray("input.txt"));
define("CONSONANTS" , ["AA","EE","II","OO","UU"]);

function convertFileToArray($file)
{
    $array = file_get_contents($file);
    $array = explode("\n", $array);
    return $array;
}

function compareArray(&$hits)
{
    foreach (MATRIX as $row) {
        foreach (CONSONANTS as $consonant) {
            if (strpos($row, $consonant) !== false) { //als er een dubbele klinker in de regel aanwezig is, dan:
                $hits[] = array($consonant,strpos($row, $consonant)); //voeg een waarde toe aan de array, bestaande uit de betreffende klinker en zijn positie in de string/regel (x-coördinaat)
            }
        }
    }
}    
//UITLEG: $hits is nu een multidimensionele array.
//Elke waarde in $hits is zijn eigen array die bestaat uit desbetreffende dubbele klinker gevonden in de huidige regel, 
//en de bijbehorende positie in de regel (x-coördinaat)


function isSquare(&$hits)
{
    echo ("Vierkanten gevonden op: " . PHP_EOL);
    for ($i = 0; $i < count($hits) - 1; $i++) {
        if ($hits[$i][0] == $hits[$i + 1][0]) { //print de coördinaten uit, als er sprake is van twee keer dezelfde dubbele klinkers in onze $hits, oftwel een vierkant van dezelfde klinkers. 
            echo ($hits[$i][0] . ": (" . $hits[$i][1] . "," . $i . ")" . PHP_EOL);
        }
    }
    echo ("Coordinaten beginnen bij 0, eerst horizontaal dan verticaal");
}

compareArray($hits);
isSquare($hits);

var_dump($hits);

//known limitations: Kan niet twee keer dezelfde dubbele klinkers in dezelfde regel detecteren. 
//Als het programma dat wel kon, zou het in dat geval een false positive geven voor een klinker-vierkant voor die regel.
