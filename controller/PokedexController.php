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

        $pokemonEncontrado = $this->model->buscarPokemonPorId($id);

        $this->presenter->render("view/InfoPokemonView.mustache", ["pokemon" => $pokemonEncontrado]);

        exit();
    }

    public function login()
    {
        session_start();

        $usuario = $_POST["name"];
        $password = $_POST["password"];

        $resultado = $this->model->iniciarSesion($usuario,$password);

        if($resultado == 1){
            header("Location:/homeUsuario");
            exit();
        }

        if($resultado == 0 || $resultado == 2 || $resultado == 3 ){
            header("Location:/pokedex");
            exit();
        }

    }
    public function crearPokemon(){
        $this->presenter->render("view/crearPokemon.mustache");
    }

    public function guardarPokemon() {
        list($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $observaciones) = $this->obtenerDatosAGuardar();

        $this->model->guardarPokemon($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $observaciones);

        header("Location: /homeUsuario");

    }

    public function buscarPokemon(){

        $usuarioLogeado = isset($_SESSION["name"]);

        $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
        $pokemones = $this->model->buscarPokemon($busqueda);

        if ($usuarioLogeado) {

            $this->presenter->render("view/homeUsuarioView.mustache", ["pokemon" => $pokemones]);
        } else {

            $this->presenter->render("view/PokedexView.mustache", ["pokemon" => $pokemones]);
        }
    }





    private function obtenerDatosAGuardar(): array
    {
        if (isset($_POST['numero_id']) && isset($_FILES['imagen']) && isset($_POST['nombre'])
            && isset($_POST['tipo1']) && isset($_POST['tipo2']) && isset($_POST['descripcion'])) {
            $numero_id = $_POST['numero_id'];
            $imagen_nombre = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME);
            $imagen_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombre = $_POST['nombre'];
            $tipo1 = $_POST['tipo1'];
            $tipo2 = $_POST['tipo2'];
            $observaciones = $_POST['descripcion'];

            $ruta_temporal_imagen = $_FILES['imagen']['tmp_name'];

            $nuevo_nombre_imagen = $imagen_nombre . '.' . $imagen_extension;

            $ruta_final_imagen = "public/imagenes/{$nuevo_nombre_imagen}";

            move_uploaded_file($ruta_temporal_imagen, $ruta_final_imagen);
        }
        return array($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $observaciones);
    }


}
