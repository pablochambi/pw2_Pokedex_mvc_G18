<?php

class LaBandaController
{
    private $presenter;

    public function __construct($presenter)
    {
        $this->presenter = $presenter;
    }

    //Controlador por defecto
    public function get()
    {
        $this->presenter->render("view/labandaView.mustache");
    }
}