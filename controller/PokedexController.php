<?php

class PokedexController
{
    private $model;
    private $presenter;

    public function __construct($model, $presenter)
    {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function get()
    {
        $pokemones = $this->model->getPokemones();
        $this->model->getPokemones();
        $this->presenter->render("view/PokedexView.mustache", ["pokemon" => $pokemones]);
    }

    public function info_pokedex()
    {
        $id = $_GET["id"];
        echo "$id";
        //$this->model->buscarPokemon($id);
       // header("location:/tours");
        exit();
    }
}
