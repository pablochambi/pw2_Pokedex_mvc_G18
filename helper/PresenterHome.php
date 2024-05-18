<?php

class PresenterHome
{

    public function __construct()
    {
    }

    public function renderHome($view, $data = [])
    {
        include_once("view/template/headerHome.mustache");
        include_once($view);
        include_once("view/template/footer.mustache");
    }

}