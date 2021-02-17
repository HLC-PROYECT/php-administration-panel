<?php


namespace Subject;


class subject
{
    private int $codasignatura;
    private string $nombre;
    private int $n_horas;
    private int $añofin;
    private int $cod_curso;
    private string $dniprofesor;

    public function __construct(int $codasignatura, string $nombre, int $n_horas, int $añofin, int $cod_curso, string $dniprofesor)
    {
        $this->codasignatura = $codasignatura;
        $this->nombre = $nombre;
        $this->n_horas = $n_horas;
        $this->añofin = $añofin;
        $this->cod_curso = $cod_curso;
        $this->dniprofesor = $dniprofesor;
    }

    public function getCodasignatura(): int
    {
        return $this->codasignatura;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getNHoras(): int
    {
        return $this->n_horas;
    }

    public function getAñoFin(): int
    {
        return $this->añofin;
    }

    public function getCodCurso(): int
    {
        return $this->cod_curso;
    }

    public function getDniprofesor(): string
    {
        return $this->dniprofesor;
    }



}