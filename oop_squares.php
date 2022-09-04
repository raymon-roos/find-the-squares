<?php

class FindBlock
{
    private array $matrix;
    private const VOWELS = ["A","E","I","O","U"];

    public function __construct($file)
    {
        $this->matrix = $this->convertFileToArray($file);
        $this->analyzeArray($this->matrix);
    }

    private function convertFileToArray($file): array
    {
        $array = explode("\n", file_get_contents($file));
        foreach ($array as $row => $str) {
            $array[$row] = str_split($str);
        }

        return $array;
    }

    private function analyzeArray(array $matrix): void
    {
        for ($y = 0; $y < count($matrix); $y++) {
            for ($x = 0; $x < count($matrix[$y]); $x++) {
                $letter = $matrix[$y][$x];
                $results[] = $this->findMatches($x, $y, $letter);
            }
        }

        $this->printResults(array_filter($results));
    }

    private function sameLetter(string $a, string $b): bool
    {
        return ($a == $b) ?: false;
    }

    private function inBounds($width, $height, $x, $y)
    {
        if (
            isset($this->matrix[$y + $height][$x + $width + 1]) &&
            isset($this->matrix[$y + $height + 1][$x + $width]) &&
            isset($this->matrix[$y + $height + 1][$x + $width + 1])
        ) {
            return true;
        }
        return false;
    }

    private function findMatches(int &$x, int &$y, string $letter): string
    {
        // note x and y coordinates are passed by reference
        list($width, $height) = 0;
        $combined = '';
        if (
            $this->inBounds($width, $height, $x, $y) &&
            in_array($letter, self::VOWELS) &&
            $this->sameLetter($letter, $this->matrix[$y][$x + $width]) &&
            $this->sameLetter($letter, $this->matrix[$y + $height][$x]) &&
            $this->sameLetter($letter, $this->matrix[$y + $height][$x + $width])
        ) {
            $width++;
            $height++;
            $combined .= (
                $letter . 
                $this->matrix[$y][$x + $width] .
                $this->matrix[$y + $height][$x + $width] . 
                $this->matrix[$y + $height][$x]
            );

            if (substr_count($combined, $letter) >= 4) { 
                $result = "($x,$y) : $letter";
                $x += sqrt(strlen($combined)); //Skipping ahead in the loop, to save time and prevent 
                $y += sqrt(strlen($combined)); //detecting a 2x2 square in 3x3 square we've already matched
                return $result;
            }
        }

        return '';
    }

    private function printResults($results)
    {
        foreach ($results as $match) {
            echo "Match at $match" . PHP_EOL;
        }
    }
}

new FindBlock('input.txt');