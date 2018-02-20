<?php
declare(strict_types=1);

namespace Mzgb\Rules;

final class Score
{
    private $points = [];

    public function __construct(Points ...$results)
    {
        foreach ($results as $result) {
            $this->points[$result->tourNumber()] = $result->total();
        }
    }

    public function total(): int
    {
        return array_sum($this->points);
    }

    public function isHigherThan(Score $that): bool
    {
        if ($this->total() > $that->total()) {
            return true;
        }
        if ($this->total() < $that->total()) {
            return false;
        }
        $tour = Tour::last();
        while ($this->pointsIn($tour) === $that->pointsIn($tour) && !$tour->isFirst()) {
            $tour = $tour->prev();
        }
        return $this->pointsIn($tour) > $that->pointsIn($tour);
    }

    public function pointsIn(Tour $tour): int
    {
        return $this->points[$tour->number()] ?? 0;
    }
}
