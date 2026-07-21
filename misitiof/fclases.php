<?php

class datospersona
{
    public function __construct( //Antes de construct se escriben 2 guiones bajos)
        private $dcodigo,
        private $dnombre,
        private $ddireccion = null,
        private $dtelresi = null,
        private $dtelcel = null,
        private $demail = null
    ) {
    }


    public function minombre(){
        return"mi codigo es:" .$this->dcodigo." y mi nombre es: Daniel Martinez: ".this->dnombre. " y direccion es: ".$this->ddireccion;
    }
    }

