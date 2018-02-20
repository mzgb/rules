<?php
declare(strict_types=1);

namespace Mzgb\Test;

use Mzgb\Rules\Points;
use Mzgb\Rules\RulesViolation;
use Mzgb\Rules\Tour;
use PHPUnit\Framework\TestCase;

class PointsTest extends TestCase
{
    public function testCantGive2PointsForRegularTour()
    {
        $this->expectException(RulesViolation::class);
        $this->expectExceptionMessage('Invalid points amount (2) for tour 1');
        new Points(Tour::byNumber(1), 0, 0, 0, 0, 1, 1, 2);
    }

    public function testCantGive3PointsForBlitz()
    {
        $this->expectException(RulesViolation::class);
        $this->expectExceptionMessage('Invalid points amount (3) for tour 7');
        new Points(Tour::byNumber(7), 0, 0, 0, 0, 1, 1, 3);
    }

    public function testCanGive2PointsForBlitz()
    {
        $this->assertNotEmpty(new Points(Tour::byNumber(7), 0, 0, 0, 0, 1, 1, 2));
    }

    public function testCanGetIndividualPoints()
    {
        $points = [1, 0, -2, 0, 1, 1, 2];
        $this->assertEquals($points, (new Points(Tour::byNumber(7), ...$points))->individual());
    }

}
