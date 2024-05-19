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
        return $this->database->query("SELECT * FROM pokemon WHERE id = $id");
    }


    public function verificarSiHayUnaSessionIniciada($session){
        return isset($session) ? $session : null;
    }

}