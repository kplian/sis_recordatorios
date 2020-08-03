<?php
class Envio
{
    private $estrategia;
    function __construct()
    {
    }

    function usarEstrategia(IEmailStrategy $estrategia)
    {
        $this->estrategia = $estrategia;
    }

    function ejecutar()
    {
        return $this->estrategia->enviar();
    }
}