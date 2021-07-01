<?php
class Persona {
    private $nombre;
    private $paterno;
    private $materno;
    private $sexo;
    private $telefono;
    private $correo;
    private $fotoPerfil;

    public function __construct() {

    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setPaterno($paterno) {
        $this->paterno = $paterno;
    }

    public function getPaterno() {
        return $this->paterno;
    }

    public function setMaterno($materno) {
        $this->materno = $materno;
    }

    public function getMaterno() {
        return $this->materno;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setFotoPerfil($fotoPerfil) {
        $this->fotoPerfil = $fotoPerfil;
    }

    public function getFotoPerfil() {
        return $this->fotoPerfil;
    }
}