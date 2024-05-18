<?php
class HomeUsuarioController
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
        session_start();
        $pokemones = $this->model->getPokemones();//buscar en la base de datos pokemones

        if(isset($_SESSION["name"])){
            $this->presenter->render("view/HomeUsuarioView.mustache", ["pokemon" => $pokemones]);
        }else{
            header("Location:/pokedex");
        }
    }


}