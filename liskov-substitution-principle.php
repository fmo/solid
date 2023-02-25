<?php

/**
 * "Functions that use pointers or references to base classes must be able to use objects of derived classes without knowing it."
 *  - Wikipedia
 */

// Breaching Liskov Substitution Principle

namespace Fmo\Solid\Breach;

Class Email
{
    protected string $subject;
    protected string $message;
    protected string $to;
    protected string $cc;
    protected string $bcc;
    public function send(): void
    {
        var_dump('Email');
    }
}

Class Sms extends Email
{
    protected string $provider;

    public function send(): void
    {
        var_dump('Sms');
    }
}

// Fixing Liskov Substitution Principle

namespace Fmo\Solid\Fix;

abstract Class Message
{
    protected string $to;
    protected string $message;
    abstract function send(): void;
}

Class Email extends Message
{
    protected string $subject;
    protected string $cc;
    protected string $bcc;
    public function send(): void
    {
        var_dump('Email');
    }
}

Class Sms extends Message
{
    protected string $provider;

    public function send(): void
    {
        var_dump('Sms');
    }
}

(new Sms())->send();
