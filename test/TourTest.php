<?php
declare(strict_types=1);

namespace Mzgb\Test;

use Mzgb\Rules\RulesViolation;
use Mzgb\Rules\Tour;
use PHPUnit\Framework\TestCase;

class TourTest extends TestCase
{
    public function testInvalidTourNumberViolateRules()
    {
        $this->expectException(RulesViolation::class);
        Tour::byNumber(42);
    }

    public function testToursAreSingletons()
    {
        foreach (range(1, 7) as $n) {
            $this->assertTrue(Tour::byNumber($n) === Tour::byNumber($n));
        }
    }

    public function testCanNotGetTourBeforeFirst()
    {
        $this->expectException(\LogicException::class);
        Tour::byNumber(1)->prev();
    }

}
