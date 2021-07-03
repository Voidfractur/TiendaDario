<?php

class Usuario {
    private $nombreUsuario;
    private $contrasenia;
    private $fechaRegistro;
    private $puesto;
    
    public function __construct() {

    }

    public function setNombreUsuario($usuario) {
        $this->nombreUsuario = $usuario;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function setContrasenia($contrasenia) {
        $this->contrasenia = $contrasenia;
    }

    public function getContrasenia() {
        return $this->contrasenia;
    }

    public function setFechaRegistro($fecha) {
        $this->fechaRegistro = $fecha;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    public function getPuesto() {
        return $this->puesto;
    }
}