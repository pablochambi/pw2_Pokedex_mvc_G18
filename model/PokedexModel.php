<?php

class PokedexModel
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

    public function buscarPokemon($id)
    {
        return $this->database->query("SELECT * FROM pokemon WHERE id = $id");
    }

    public function buscarUsuario($usuario,$password)
    {
        return $this->database->executeAndReturn("SELECT * FROM usuario WHERE name = '$usuario' AND password = '$password'");
    }


    public function iniciarSesion($resultado,$usuario)
    {
        if (mysqli_num_rows($resultado) == 1) {
            session_start();
            $_SESSION["name"] = $usuario;
            header("Location: /homeUsuario");
            exit();
        } else {
            header("Location: /pokedex");
            exit();
        }
    }
}