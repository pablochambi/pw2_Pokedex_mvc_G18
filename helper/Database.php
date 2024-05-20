<?php

class Database
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function query($sql){
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function execute($sql)
    {
        mysqli_query($this->conn, $sql);
    }

    public function executeAndReturn($sql)
    {
       return mysqli_query($this->conn, $sql);
    }

    public function obtenerUnArrayConLosDatosDeUnPokemonPorId($query) :array
    {
        $pokemonBuscado = mysqli_query($this->conn, $query);

        if ($pokemonBuscado) {

            if (mysqli_num_rows($pokemonBuscado) > 0) {

                return mysqli_fetch_assoc($pokemonBuscado);
            } else {
                echo "No se encontró ningún Pokémon con el ID";
                return [];
            }
        } else {

            echo "Error al ejecutar la consulta: " . mysqli_error($this->conn);
            return [];
        }

    }


    public function __destruct()
    {
        mysqli_close($this->conn);
    }

}