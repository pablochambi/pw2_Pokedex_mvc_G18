<?php

include_once ("controller/PokedexController.php");
include_once("controller/HomeUsuarioController.php");

include_once ("model/PokedexModel.php");
include_once ("model/HomeUsuarioModel.php");

include_once ("helper/Database.php");
include_once ("helper/Router.php");

include_once ("helper/Presenter.php");
include_once ("helper/PresenterHome.php");
include_once ("helper/MustachePresenter.php");
include_once ("helper/MustachePresenterHome.php");

include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{

    // CONTROLLERS
    public static function getPokedexController()
    {
        return new PokedexController(self::getPokedexModel(), self::getPresenter());
    }

    public static function getHomeUsuarioController()
    {
        return new HomeUsuarioController(self::getHomeUsuarioModel(), self::getPresenterHome());
    }

    // MODELS

    private static function getPokedexModel()
    {
        return new PokedexModel(self::getDatabase());
    }

    private static function getHomeUsuarioModel()
    {
        return new HomeUsuarioModel(self::getDatabase());
    }


    // HELPERS
    //Para crear la conexion a la Base de Datos
    public static function getDatabase()
    {
        $config = self::getConfig();
        return new Database($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    }

    private static function getConfig()
    {
        return parse_ini_file("config/config.ini");
    }

    //Si lo que te piden no existe agarra este particular
    public static function getRouter()
    {
        return new Router("getPokedexController", "get");
    }

    private static function getPresenter()
    {
        return new MustachePresenter("view/template");
    }

    private static function getPresenterHome()
    {
        return new MustachePresenterHome("view/template");
    }



}