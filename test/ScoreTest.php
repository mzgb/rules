<?php
declare(strict_types=1);

namespace Mzgb\Test;

use Mzgb\Rules\Points;
use Mzgb\Rules\Score;
use Mzgb\Rules\Tour;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    public function testScoreReturnsPointsByTour()
    {
        $score = new Score(
            new Points(Tour::byNumber(2), 0, 0, 0, 1, 1, 1, 1),
            new Points(Tour::byNumber(1), 0, 1, 0, 1, 1, 1, 1),
            new Points(Tour::byNumber(4), 0, 0, 0, 1, 1, 1, 1),
            new Points(Tour::byNumber(3), 1, 1, 1, 1, 1, 1, 1)
        );
        $this->assertEquals(5, $score->pointsIn(Tour::byNumber(1)));
    }

    public function testScoreIsNotHigherThanItself()
    {
        $score = new Score(
            new Points(Tour::byNumber(1), 0, 0, 0, 1, 1, 1, 1)
        );
        $this->assertFalse($score->isHigherThan($score));
    }

    public function testScoreIsHigherIfHasMoreTotalPoints()
    {
        $alice = new Score(
            new Points(Tour::byNumber(1), 0, 0, 0, 1, 1, 1, 1)
        );
        $bob = new Score(
            new Points(Tour::byNumber(1), 1, 1, 1, 1, 1, 1, 1)
        );
        $this->assertEquals(4, $alice->total());
        $this->assertEquals(7, $bob->total());
        $this->assertTrue($bob->isHigherThan($alice));
        $this->assertFalse($alice->isHigherThan($bob));
    }

    public function testScoreIsHigherIfAcquiredMorePointsInLatestTour()
    {
        $alice = new Score(
            new Points(Tour::byNumber(1), 1, 1, 1, 1, 1, 1, 1),
            new Points(Tour::byNumber(2), 0, 0, 0, 1, 1, 1, 1)
        );
        $bob = new Score(
            new Points(Tour::byNumber(1), 0, 0, 0, 1, 1, 1, 1),
            new Points(Tour::byNumber(2), 1, 1, 1, 1, 1, 1, 1) // more point in 2nd tour
        );
        $this->assertTrue(($alice->total() === $bob->total()));
        $this->assertTrue($bob->isHigherThan($alice));
        $this->assertFalse($alice->isHigherThan($bob));
    }

}
