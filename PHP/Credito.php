<?php
class Credito {
    private $pagoInicial;
    private $status;

    public function __construct($pagoInicial, $status) {
        if($pagoInicial == "") {
            $this->pagoInicial = 0;
            $this->status = $status;
        }
        else {
            $this->pagoInicial = $pagoInicial;
            $this->status = $status;
        }
    }

    public function setPagoInicial($inicial) {
        if($inicial == "") { $this->pagoInicial = 0; return; }
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