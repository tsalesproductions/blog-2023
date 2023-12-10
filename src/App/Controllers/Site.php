<?php
    namespace App\Controllers;

    use App\Modules\Render;
    use App\Modules\Connection;
    
    class Site{
        public function __construct($router)
        {
            $this->router = $router;
        }

        public function render_index(){
            Render::render($this->router->current()->name, []);
        }
    }