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

    public function getImagenesPokemones()
    {
        return "/";
    }
}