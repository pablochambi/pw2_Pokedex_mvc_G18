<?php
class HomeUsuarioController
{
    private $model;
    private $presenterHome;

    public function __construct($model, $presenterHome)
    {
        $this->model = $model;
        $this->presenterHome = $presenterHome;
    }

    public function get()
    {
        session_start();
        $pokemones = $this->model->getPokemones();

        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["name"]);

        if($nombreUsuario){
            // Renderizar la plantilla y pasar los datos
            $this->presenterHome->renderHome("view/HomeUsuarioView.mustache", ["name" => $nombreUsuario, "pokemon" => $pokemones]);
        }else{
            header("Location:/pokedex");
        }

    }


    public function logout()
    {
        session_start();

        session_destroy();

        header('Location: index.php');
    }

    public function info_pokedex()
    {
        $id = $_GET["id"];

        $pokemonEncontrado = $this->model->buscarPokemon($id);

        $this->presenter->render("view/InfoPokemonView.mustache", ["pokemon" => $pokemonEncontrado]);

        exit();
    }


}