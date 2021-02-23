<?php

namespace HLC\AP\Domain\Teacher;

final class User
{
    private string $identificationDocument;
   
    public function __construct(string $identificationDocument) {
        $this->identificationDocument = $identificationDocument;
    }

    public function getIdentificationDocument(): string
    {
        return $this->identificationDocument;
    }

    public static function build(string $identificationDocument): self {
        return new self($identificationDocument);
    }
}