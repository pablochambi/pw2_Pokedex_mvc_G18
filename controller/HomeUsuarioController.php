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


    public function modificarPokemon(){
        session_start();
        // Recuperar el ID del Pokémon a modificar de la URL
        $id = isset($_GET['id']) ? $_GET['id'] : "";

        $pokemonBuscado = $this->model->buscarUnPokemonPorIdYRetornarSusDatosEnUnArray($id);

        $numero_id = $pokemonBuscado["numero_id"];
        $nombre = $pokemonBuscado["nombre"];
        $direccionImagen = $pokemonBuscado["imagen"];
        $direccionTipo1 = $pokemonBuscado["tipo1"];
        $direccionTipo2 = $pokemonBuscado["tipo2"];
        $descripcion = $pokemonBuscado["descripcion"];

        $explode1 = explode("/", $direccionTipo1);
        $explode2 = explode("/", $direccionTipo2);

        $tipo1png = end($explode1);
        $tipo2png = end($explode2);

        $tipo1 = basename($tipo1png,".png");
        $tipo2 = basename($tipo2png,".png");

        $pokemonBuscado = [
            "id" => $id,
            "numero" => $numero_id,
            "nombre" => $nombre,
            "direccionImagen" => $direccionImagen,
            "tipo1" => $tipo1,
            "tipo2" => $tipo2,
            "descripcion" => $descripcion
        ];

        $nombreUsuario = $this->model->verificarSiHayUnaSessionIniciada($_SESSION["name"]);

        if($nombreUsuario){
            // Renderizar la plantilla y pasar los datos
            $this->presenterHome->renderHome("view/modificarPokemonView.mustache", ["name" => $nombreUsuario, "pokemon" => $pokemonBuscado]);
        }else{
            header("Location:/pokedex");
        }

    }


    public function procesarModificacionPokemon(){

        if (isset($_POST['id']) && isset($_POST['numero_id']) && isset($_POST['nombre'])
            && isset($_POST['tipo1']) && isset($_POST['tipo2']) && isset($_POST['descripcion'])) {

            $id = $_POST['id'];
            $numero_id = $_POST['numero_id'];
            $nombre = $_POST['nombre'];
            $tipo1 = $_POST['tipo1'];
            $tipo2 = $_POST['tipo2'];
            $descripcion = $_POST['descripcion'];

        }else {
            echo "No se proporcionaron todos los datos necesarios.";
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
        } else {
            $imagen = false;
        }

        //si existe la imagen...
        if($imagen){
            // Verificar si la extensión del archivo es PNG
            $imagen_extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
            if ($imagen_extension !== 'png') {
                die("<script>alert('La imagen debe ser un archivo PNG'); window.location.href = '/homeUsuario'</script>");
            }

            // Verificar si el número ID ya existe en la base de datos

            // Mover la imagen cargada al directorio de imágenes

            $imagen_nombre = pathinfo($imagen['name'], PATHINFO_FILENAME);
            $imagen_destino = "/public/imagenes/{$imagen_nombre}.png";
            move_uploaded_file($imagen['tmp_name'], $imagen_destino);
        }else {
            $direccionImagenPorDefecto = isset($_POST['direccionImagenPorDefecto']) ? $_POST['direccionImagenPorDefecto'] : "Error no se ve la direccion de imagen";

            $imagen_nombre = pathinfo(basename($direccionImagenPorDefecto), PATHINFO_FILENAME);
            $imagen_destino = $direccionImagenPorDefecto;
        }

        $tipo1Ref = "public/imagenes/tipo/" . $tipo1 . ".png";
        $tipo2Ref = "public/imagenes/tipo/" . $tipo2 . ".png";

        $resultado = $this->model->actualizarLosDatosDeUnPokemonPorId($id,$numero_id,$nombre,$imagen_destino,$tipo1Ref,$tipo2Ref,$descripcion);

        //*****************  Testear este if ********************
        if (!(file_exists("public/imagenes/{$imagen_nombre}.png"))) {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "public/imagenes/{$imagen_nombre}.png");
        }

        if ($resultado) {
            header("Location:/homeUsuario");//Me mantiene la Session
        } else {
            die("<script>alert('Error al actualizar los datos del Pokémon '); window.location.href = '/homeUsuario'</script>");
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