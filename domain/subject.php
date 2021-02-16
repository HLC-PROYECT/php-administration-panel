<?php


namespace Subject;


class subject
{
    private int $codasignatura;
    private string $nombre;
    private int $n_horas;
    private int $año_fin;
    private int $cod_curso;
    private string $dniprofesor;

    /**
     * subject constructor.
     * @param int $codasignatura
     * @param string $nombre
     * @param int $n_horas
     * @param int $año_fin
     * @param int $cod_curso
     * @param string $dniprofesor
     */
    public function __construct(int $codasignatura, string $nombre, int $n_horas, int $año_fin, int $cod_curso, string $dniprofesor)
    {
        $this->codasignatura = $codasignatura;
        $this->nombre = $nombre;
        $this->n_horas = $n_horas;
        $this->año_fin = $año_fin;
        $this->cod_curso = $cod_curso;
        $this->dniprofesor = $dniprofesor;
    }

    /**
     * @return int
     */
    public function getCodasignatura(): int
    {
        return $this->codasignatura;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getNHoras(): int
    {
        return $this->n_horas;
    }

    /**
     * @return int
     */
    public function getAñoFin(): int
    {
        return $this->año_fin;
    }

    /**
     * @return int
     */
    public function getCodCurso(): int
    {
        return $this->cod_curso;
    }

    /**
     * @return string
     */
    public function getDniprofesor(): string
    {
        return $this->dniprofesor;
    }



}