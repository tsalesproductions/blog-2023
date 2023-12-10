<?php
    namespace App\Modules;

    class Render{
        public static function render($page, $params){
            
            $loader = new \Twig\Loader\FilesystemLoader(isset($_SESSION['email']) ? APP_DIR_ADMIN : APP_DIR_SITE);
            $twig = new \Twig\Environment($loader, ['debug' => true]);
            $twig->addExtension(new \Twig\Extra\Intl\IntlExtension());
            $twig->addExtension(new \Twig\Extension\DebugExtension());

            # DEFAULT URL
            $twig->addGlobal('APP_URL', APP_URL);
            $twig->addGlobal('APP_PAGE', $page);
            
            echo $twig->render('default.html', $params);
        }
    }