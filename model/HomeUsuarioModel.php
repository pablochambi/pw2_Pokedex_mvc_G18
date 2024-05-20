<?php
class HomeUsuarioModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getPokemones()
    {
        return $this->database->query("SELECT * FROM pokemon");
    }

    public function buscarPokemonPorId($id)
    {
        return  $this->database->query("SELECT * FROM pokemon WHERE id = $id");
    }

    public function buscarUnPokemonPorIdYRetornarSusDatosEnUnArray($id) : array
    {
        return  $this->database->obtenerUnArrayConLosDatosDeUnPokemonPorId("SELECT * FROM pokemon WHERE id = $id");
    }

    public function actualizarLosDatosDeUnPokemonPorId($id,$numero_id,$nombre,$imagen_destino,$tipo1Ref,$tipo2Ref,$descripcion)
    {
        $actualizacion = "UPDATE pokemon SET 
              numero_id = '$numero_id',
              nombre = '$nombre', 
              imagen = '$imagen_destino',
              tipo1 = '$tipo1Ref',  
              tipo2 = '$tipo2Ref', 
              descripcion = '$descripcion'
              WHERE id = '$id'";

        return  $this->database->executeAndReturn($actualizacion);

    }




    public function verificarSiHayUnaSessionIniciada($session){
        return isset($session) ? $session : null;
    }

    public function buscarPokemon($busqueda){
        $sql = "SELECT * FROM pokemon";

        if (!empty($busqueda)) {
            $sql .= " WHERE nombre LIKE '%$busqueda%'";
        }

        return $this->database->executeAndReturn($sql);

    }

    public function guardarPokemon($numero_id, $imagen_nombre, $nombre, $tipo1, $tipo2, $descripcion) {
        $imagenRef = "public/imagenes/{$imagen_nombre}.png";
        $tipo1Ref = "public/imagenes/tipo/{$tipo1}.png";
        $tipo2Ref = "public/imagenes/tipo/{$tipo2}.png";

        $sql = $this->construirLaConsultaSQL($tipo1, $tipo2, $numero_id, $imagenRef, $nombre, $tipo1Ref, $descripcion, $tipo2Ref);

        $query_result = $this->database->execute($sql);
        $this->moverLaImagen($query_result, $imagen_nombre);



        return $query_result;
    }

    private function construirLaConsultaSQL($tipo1, $tipo2, $numero_id, string $imagenRef, $nombre, string $tipo1Ref, $descripcion, string $tipo2Ref): string
    {
        if ($tipo1 === $tipo2) {
            $sql = "INSERT INTO pokemon (numero_id, imagen, nombre, tipo1, descripcion) VALUES ('$numero_id', '$imagenRef', '$nombre', '$tipo1Ref', '$descripcion')";
        } else {
            $sql = "INSERT INTO pokemon (numero_id, imagen, nombre, tipo1, tipo2, descripcion) VALUES ('$numero_id', '$imagenRef', '$nombre', '$tipo1Ref', '$tipo2Ref', '$descripcion')";
        }
        return $sql;
    }


    private function moverLaImagen($query_result, $imagen_nombre)
    {
        if ($query_result && !file_exists("imagenes/{$imagen_nombre}.png")) {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "imagenes/{$imagen_nombre}.png");
        }
    }


    private function seEncontroUnResultado($resultado){
        return mysqli_num_rows($resultado) == 1;
    }


}