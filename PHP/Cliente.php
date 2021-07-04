<?php
class Cliente {
    private $fechaRegistro;
    private $horaRegistro;
    private $tipoCliente;

    public function __construct() {

    }

    public function setFechaRegistro($fecha) {
        $this->fechaRegistro = $fecha;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setHoraRegistro($hora) {
        $this->horaRegistro = $hora;
    }

    public function getHoraRegistro() {
        return $this->horaRegistro;
    }

    public function setTipoCliente($tipo) {
        $this->tipoCliente = $tipo;
    }

    public function getTipoCliente() {
        return $this->tipoCliente;
    }
}