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
        $pokemones = $this->model->getPokemones();//buscar en la base de datos pokemones
        $this->presenter->render("view/PokedexView.mustache", ["pokemon" => $pokemones]);
    }

    public function info_pokedex()
    {
        $id = $_GET["id"];

        $pokemonEncontrado = $this->model->buscarPokemon($id);

        $this->presenter->render("view/InfoPokemonView.mustache", ["pokemon" => $pokemonEncontrado]);

        exit();
    }

    public function login()
    {
        $usuario = $_POST ["name"];
        $password = $_POST["password"];

        $resultado = $this->model->buscarUsuario($usuario,$password);

        $this->model->iniciarSesion($resultado,$usuario);
    }

    public function procesarAlta()
    {
        $tourName = $_POST["tourName"];
        $this->model->addTour($tourName);
        header("location:/tours");
        exit();
    }
}
