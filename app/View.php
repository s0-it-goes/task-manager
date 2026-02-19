<?php

declare(strict_types=1);

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
        return new static($view, $params);
    }

    private function render(): string
    {
        $pathView = VIEWS_PATH . '/' . $this->view . '.php';

        if(!file_exists($pathView)) {

            throw new \Exception('view "' . $pathView . '" does not exist');
        }

        ob_start();

        extract($this->params);

        include VIEWS_PATH . '/' . $this->view . '.php';

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        
        return $this->render();
    }
}