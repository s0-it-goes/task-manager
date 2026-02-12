<?php

namespace App;

class View
{
    public function __construct(
        private string $view,
        private array $params
    )
    {
    }

    public static function make(string $view, array $params = [])
    {
        return new View($view, $params);
    }

    private function render(): string
    {
        $pathView = VIEWS_PATH . '/' . $this->view . '.php';
        
        ob_start();

        if(!file_exists($pathView)) {
            throw new \Exception('view "' . $pathView . '" does not exist');
        }

        include VIEWS_PATH . '/' . $this->view . '.php';

        return (string) ob_get_clean();
    }

    public function __tostring()
    {
        return $this->render();
    }
}