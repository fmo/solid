<?php

/**
 * "Clients should not be forced to depend upon interfaces that they do not use."
 *  - Wikipedia
 */

// Breaching Interface Segregation Principle

namespace Fmo\Solid\Breach;

use Exception;

interface Features
{
    public function canEat(): void;
    public function canFly(): void;
    public function canJump(): void;
}

class Seagull implements Features
{
    public function canEat(): void
    {
        var_dump('i can eat');
    }

    public function canFly(): void
    {
        var_dump('i can fly');
    }

    public function canJump(): void
    {
        var_dump('i can jump');
    }
}

class Chicken implements Features
{
    public function canEat(): void
    {
        var_dump('i can eat');
    }

    /**
     * @throws Exception
     */
    public function canFly(): void
    {
        throw new Exception('i can\'t fly');
    }

    public function canJump(): void
    {
        var_dump('i can jump');
    }
}

// Fixing Interface Segregation Principle

namespace Fmo\Solid\Fix;

use Exception;

interface Features
{
    public function canEat(): void;
    public function canJump(): void;
}

interface SuperFeatures
{
    public function canFly(): void;
}

class Seagull implements Features, SuperFeatures
{
    public function canEat(): void
    {
        var_dump('i can eat');
    }

    public function canFly(): void
    {
        var_dump('i can fly');
    }

    public function canJump(): void
    {
        var_dump('i can jump');
    }
}

class Chicken implements Features
{
    public function canEat(): void
    {
        var_dump('i can eat');
    }

    public function canJump(): void
    {
        var_dump('i can jump');
    }
}

(new Chicken())->canEat();
