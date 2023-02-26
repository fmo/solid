<?php

/**
 * "Functions that use pointers or references to base classes must be able to use objects of derived classes without knowing it."
 *  - Wikipedia
 */

// Breaching Liskov Substitution Principle

namespace Fmo\Solid\Breach;

class Rectangle
{
    protected int $width;
    protected int $height;

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function area(): int
    {
        return $this->height * $this->width;
    }
}

class Square extends Rectangle
{
    public function setHeight(int $value): void
    {
        $this->width = $value;
        $this->height = $value;
    }

    public function setWidth(int $value): void
    {
        $this->width = $value;
        $this->height = $value;
    }
}

$square = new Square;
$square->setHeight(5);
$square->setWidth(4);
echo $square->area()."\n<br />";

