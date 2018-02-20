<?php
declare(strict_types=1);

namespace Mzgb\Rules;

final class Tour
{
    private $number;

    private function __construct(int $number)
    {
        $this->number = $number;
    }

    public static function byNumber(int $number): Tour
    {
        static $tours;
        if (empty($tours)) {
            foreach (range(1, 7) as $n) {
                $tours[$n] = new Tour($n);
            }
        }
        if (isset($tours[$number])) {
            return $tours[$number];
        }
        throw new RulesViolation("Invalid tour number: $number");
    }

    public static function last(): Tour
    {
        return self::byNumber(7);
    }

    public function prev(): Tour
    {
        if ($this->isFirst()) {
            throw new \LogicException();
        }
        return self::byNumber($this->number() - 1);
    }

    public function isPointAmountValid(int $p): bool
    {
        return in_array($p, $this->allowedPoints(), true);
    }

    public function number(): int
    {
        return $this->number;
    }

    public function isFirst(): bool
    {
        return $this->number() === 1;
    }

    public function __toString(): string
    {
        return (string) $this->number();
    }

    private function allowedPoints(): array
    {
        return $this->isBlitz() ? [0, 1, -2, 2] : [0, 1];
    }

    private function isBlitz(): bool
    {
        return $this->number() === 7;
    }
}