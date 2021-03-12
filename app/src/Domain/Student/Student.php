<?php

namespace HLC\AP\Domain\Student;


use HLC\AP\Domain\User\User;

class Student extends User
{
    public string $identificationDocument;
    private string $birthDate;
    private string $courseId;

    public function __construct(
        string $identificationDocument,
        string $birthDate,
        string $courseId,
        string $email,
        string $password,
        string $nick,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $dateUpdate,
        string $type
    )
    {
        parent::__construct(
            $identificationDocument,
            $email,
            $password,
            $nick,
            $name,
            $dateStart,
            $dateEnd,
            $dateUpdate,
            $type
        );
        $this->identificationDocument = $identificationDocument;
        $this->birthDate = $birthDate;
        $this->courseId = $courseId;
    }

    public function getIdentificationDocument(): string
    {
        return $this->identificationDocument;
    }

     public static function buildStudent(
        string $identificationDocument,
        string $email,
        string $password,
        string $nick,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $dateUpdate,
        string $type,
        string $birthDate,
        string $courseId,
    ): self
    {
        return new self(
            $identificationDocument,
            $birthDate,
            $courseId,
            $email,
            $password,
            $nick,
            $name,
            $dateStart,
            $dateEnd,
            $dateUpdate,
            $type
        );
    }

    public function getCourseId(): string
    {
        return $this->courseId;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }
}