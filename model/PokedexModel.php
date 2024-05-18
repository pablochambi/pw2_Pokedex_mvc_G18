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


    public function iniciarSesion($usuario,$password)
    {
        $seInicioSesion = 0;
        if(isset($usuario) && isset($password)){

            $resultado = $this->buscarUsuario($usuario,$password);

            if ($this->seEncontroUnResultado($resultado)) {

                $_SESSION["name"] = $usuario;
                $seInicioSesion = 1; //se inicio sesion

            } else {
                $seInicioSesion = 2; //no se encontro en la base de datos
            }
        }else{
            $seInicioSesion = 3; // se dejo por lo menos un campo vacio
        }

        return $seInicioSesion;
    }

    private function seEncontroUnResultado($resultado){
        return mysqli_num_rows($resultado) == 1;
    }


}