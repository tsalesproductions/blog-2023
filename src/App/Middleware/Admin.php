<?php

namespace App\Middleware;

use CoffeeCode\Router\Router;

class Admin
{
    public function handle(Router $router): bool
    {
        $user = isset($_SESSION['email']) ? true : false;
        // var_dump($router->current());
        if (!$user) {
            if($router->current()->route !== '/admin/login' && $router->current()->route !== '/admin/auth'){
                Controller::redirect("/admin/login");
                return true;
            }

            return true;
        }else{
            if($router->current()->route == '/admin/login'){
                Controller::redirect("/admin/index");
            }
        }
        return true;
    }
}