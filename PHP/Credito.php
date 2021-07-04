<?php
class Credito {
    private $pagoInicial;
    private $status;

    public function __construct($pagoInicial, $status) {
        $this->pagoInicial = $pagoInicial;
        $this->status = $status;
    }

    public function setPagoInicial($inicial) {
        $this->pagoInicial = $inicial;
    }

    public function getPagoInicial() {
        return $this->pagoInicial;
    }

    public function setStatus($status) { 
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }
}