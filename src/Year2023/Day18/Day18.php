<?php

declare(strict_types=1);

namespace App\Year2023\Day18;

use App\AbstractPuzzle;
use App\Result;

final class Day18 extends AbstractPuzzle
{
    private const array DIRECTIONS = [
        'R' => [0, 1],
        'L' => [0, -1],
        'D' => [1, 0],
        'U' => [-1, 0],
    ];
    private const string REGEX = '#^(?<direction>[RDLU])\s+(?<count>\d+)\s+\((?<color>\#[a-f0-9]{6})\)$#';

    /** @var list<list<string>> */
    private array $map = [['#']];

    /** @var array{0: int, 1: int} */
    private array $currentPosition = [0, 0];
    private int $maxI = 0;
    private int $maxJ = 0;

    public function run(): Result
    {
        $pt1 = $pt2 = 0;

        foreach ($this->readFile() as $line) {
            preg_match(self::REGEX, $line, $matches);
            ['direction' => $direction, 'count' => $count] = $matches;

            $this->moveCursor($direction, (int) $count);
        }

        foreach ($this->map as $line) {
            $str = implode('', $line);
            $first = strpos($str, '#');
            $last = strrpos($str, '#');

            $pt1 += ($last - $first) + 1;
        }

        return new Result($pt1, $pt2);
    }

    /**
     * @param int<1, max> $count
     */
    private function moveCursor(string $direction, int $count): void
    {
        for ($i = 1; $i <= $count; $i++) {
            $newI = $this->currentPosition[0] + self::DIRECTIONS[$direction][0];
            $newJ = $this->currentPosition[1] + self::DIRECTIONS[$direction][1];

            if ($newI > $this->maxI) {
                $this->map[$newI] = array_fill(0, $this->maxJ + 1, '.');
                $this->maxI = $newI;
            }
            if ($newJ > $this->maxJ) {
                foreach ($this->map as &$mapLine) $mapLine[$newJ] = '.';
                $this->maxJ = $newJ;
            }

            $this->map[$newI][$newJ] = '#';
            $this->currentPosition = [$newI, $newJ];
        }
    }
}
