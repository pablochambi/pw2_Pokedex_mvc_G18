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
        session_start();
        $id = $_GET["id"];
        $pokemonEncontrado = $this->model->buscarPokemonPorId($id);
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["name"]);

        if($nombreUsuario){
            // Renderizar la plantilla y pasar los datos
            $this->presenterHome->renderHome("view/InfoPokemonView.mustache", ["name" => $nombreUsuario, "pokemon" => $pokemonEncontrado]);
        }else{
            header("Location:/pokedex");
        }
    }
    public function buscarPokemon(){
        session_start();
        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $pokemonesBuscados = $this->model->buscarPokemon($busqueda);
        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["name"]);

        if($nombreUsuario){
            // Renderizar la plantilla y pasar los datos
            $this->presenterHome->renderHome("view/HomeUsuarioView.mustache", ["name" => $nombreUsuario, "pokemon" => $pokemonesBuscados]);
        }else{
            header("Location:/pokedex");
        }
    }


}