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

    public function buscarPokemon($id)
    {
        return $this->database->query("SELECT * FROM pokemon WHERE id = $id");
    }

}