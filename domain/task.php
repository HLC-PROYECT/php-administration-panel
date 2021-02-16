<?php


namespace Task;


final class task
{

    private int $codtarea;
    private string $nombre;
    private string $descripcion;
    private string $f_inicio;
    private string $f_fin;
    private string $estado;

    /**
     * task constructor.
     * @param int $codtarea
     * @param string $nombre
     * @param string $descripcion
     * @param string $f_inicio
     * @param string $f_fin
     * @param string $estado
     */
    public function __construct(int $codtarea, string $nombre, string $descripcion, string $f_inicio, string $f_fin, string $estado)
    {
        $this->codtarea = $codtarea;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->f_inicio = $f_inicio;
        $this->f_fin = $f_fin;
        $this->estado = $estado;
    }

    /**
     * @return int
     */
    public function getCodtarea(): int
    {
        return $this->codtarea;
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
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @return string
     */
    public function getFInicio(): string
    {
        return $this->f_inicio;
    }

    /**
     * @return string
     */
    public function getFFin(): string
    {
        return $this->f_fin;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }


}