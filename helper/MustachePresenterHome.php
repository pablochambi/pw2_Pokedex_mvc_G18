<?php

class MustachePresenterHome{
    private $mustache;
    private $partialsPathLoader;

    public function __construct($partialsPathLoader){
        Mustache_Autoloader::register();
        $this->mustache = new Mustache_Engine(
            array(
                'partials_loader' => new Mustache_Loader_FilesystemLoader( $partialsPathLoader )
            ));
        $this->partialsPathLoader = $partialsPathLoader;
    }

    public function renderHome($contentFile , $data = array() ){
        echo  $this->generateHtmlHome($contentFile, $data);
    }

    public function generateHtmlHome($contentFile, $data = array()) {
        $contentAsString = file_get_contents(  $this->partialsPathLoader .'/headerHome.mustache');
        $contentAsString .= file_get_contents( $contentFile );
        $contentAsString .= file_get_contents($this->partialsPathLoader . '/footer.mustache');
        return $this->mustache->render($contentAsString, $data);
    }
}