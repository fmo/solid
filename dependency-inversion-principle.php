<?php

/**
 * "Depend upon abstractions, [not] concretions."
 *  - Wikipedia
 */

// Breaching Dependency Inversion Principle

namespace Fmo\Solid\Breach;

class PDFGenerator
{
    public function generate(): void
    {

    }
}

class CreateInvoice
{
    public function __construct(private PDFGenerator $pdfGenerator)
    {
    }

    public function __invoke(): void
    {
        $this->pdfGenerator->generate();
    }
}

// Fixing Dependency Inversion Principle

namespace Fmo\Solid\Fix;

interface FileGeneratorInterface
{
    public function generate(): void;
}

class PDFGenerator implements FileGeneratorInterface
{
    public function generate(): void
    {
        var_dump('PDF Created');
    }
}

class TextGenerator implements FileGeneratorInterface
{

    public function generate(): void
    {
        var_dump('Text created');
    }
}

class CreateInvoice
{
    public function __construct(private FileGeneratorInterface $fileGenerator)
    {
    }

    public function __invoke(): void
    {
        $this->fileGenerator->generate();
    }
}

(new CreateInvoice(new PDFGenerator()))();
