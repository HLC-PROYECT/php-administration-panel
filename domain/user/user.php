<?php

namespace User;

final class User
{

    private string $dni;
    private string $email;
    private string $password;
    private string $nombre_usuario;
    private string $nombre;
    private string $f_alta;
    private string $tipo;

    /**
     * User constructor.
     * @param string $dni
     * @param string $email
     * @param string $password
     * @param string $nombre_usuario
     * @param string $nombre
     * @param string $f_alta
     * @param string $tipo
     */
    public function __construct(string $dni, string $email, string $password, string $nombre_usuario, string $nombre, string $f_alta, string $tipo)
    {
        $this->dni = $dni;
        $this->email = $email;
        $this->password = $password;
        $this->nombre_usuario = $nombre_usuario;
        $this->nombre = $nombre;
        $this->f_alta = $f_alta;
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getDni(): string
    {
        return $this->dni;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getNombreUsuario(): string
    {
        return $this->nombre_usuario;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getFAlta(): string
    {
        return $this->f_alta;
    }

    /**
     * @return string
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }


}