<?php


namespace Course;


class Course
{
//TODO(): Rellenar datos
    private int $codCurso;
    private string $centro;
    private int $año_ini;
    private int $año_fin;
    private string $descripcion;

    /**
     * Course constructor.
     * @param int $codCurso
     * @param string $centro
     * @param int $año_ini
     * @param int $año_fin
     * @param string $descripcion
     */
    public function __construct(int $codCurso, string $centro, int $año_ini, int $año_fin, string $descripcion)
    {
        $this->codCurso = $codCurso;
        $this->centro = $centro;
        $this->año_ini = $año_ini;
        $this->año_fin = $año_fin;
        $this->descripcion = $descripcion;
    }

    /**
     * @return int
     */
    public function getCodCurso(): int
    {
        return $this->codCurso;
    }

    /**
     * @return string
     */
    public function getCentro(): string
    {
        return $this->centro;
    }

    /**
     * @return int
     */
    public function getAñoIni(): int
    {
        return $this->año_ini;
    }

    /**
     * @return int
     */
    public function getAñoFin(): int
    {
        return $this->año_fin;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }


}