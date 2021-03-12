<?php

namespace HLC\AP\Domain\User;

class User
{
    public string $identificationDocument;
    public string $name;
    private string $email;
    private string $password;
    private string $nick;
    private string $dateStart;
    private string $dateEnd;
    private string $dateUpdate;
    private string $type;

    public function __construct(
        string $identificationDocument,
        string $email,
        string $password,
        string $nick,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $dateUpdate,
        string $type
    ) {
        $this->identificationDocument = $identificationDocument;
        $this->email = $email;
        $this->password = $password;
        $this->nick = $nick;
        $this->name = $name;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->dateUpdate = $dateUpdate;
        $this->type = $type;
    }

    public static function build(
        string $identificationDocument,
        string $email,
        string $password,
        string $nick,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $dateUpdate,
        string $type
    ): self {
        return new self(
            $identificationDocument,
            $email,
            $password,
            $nick,
            $name,
            $dateStart,
            $dateUpdate,
            $dateEnd,
            $type
        );
    }

    public function getIdentificationDocument(): string
    {
        return $this->identificationDocument;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDateUpdate(): string
    {
        return $this->dateUpdate;
    }

    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }
}
