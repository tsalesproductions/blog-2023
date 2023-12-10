<?php
    namespace App;

    use CoffeeCode\Router\Router;
    use App\Middleware\Middlewares as Middleware;

    $router = new Router(APP_URL);
    
    $router->namespace("App\Controllers");

    /*
    * Sites routes
    */
    $router->get("/", "Site:render_index", "home");

    
    $router->dispatch();

    /*
    * Redirect all errors
    */
    if ($router->error()) {
        $router->redirect("/error/{$router->error()}");
    }

