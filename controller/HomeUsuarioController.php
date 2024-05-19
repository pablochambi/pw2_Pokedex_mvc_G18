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

    public function crearPokemon(){
        $this->presenterHome->renderHome("view/crearPokemon.mustache");
    }

    public function guardarPokemon() {
        list($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $observaciones) = $this->obtenerDatosAGuardar();

        $this->model->guardarPokemon($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $observaciones);

        header("Location: /homeUsuario");

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