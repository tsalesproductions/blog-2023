<?php
    namespace App\Controllers;

    use App\Modules\Render;
    use App\Modules\Connection;
    
    class Site{
        public function __construct($router)
        {
            $this->router = $router;
            $this->con = new Connection();
        }

        public function render_index(){
            Render::render($this->router->current()->name, [
                "posts" => [
                    "recents" => $this->con->select('posts', '*', 'status = 1', 'id DESC', []),
                    "most_liked" => $this->con->select('posts', '*', 'status = 1', 'likes DESC', []),
                    "most_viewed" => $this->con->select('posts', '*', 'status = 1', 'views DESC', []),
                    "fixed" => $this->con->select('posts', '*', 'status = 1 AND fixed = 1', 'id DESC', [])
                ],
                "banners" => $this->con->select('banners', '*', 'status = 1', 'id DESC', [])
            ]);
        }
    }