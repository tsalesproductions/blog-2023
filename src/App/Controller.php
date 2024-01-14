<?php

    namespace App;

    use App\Modules\Connection;

    class Controller extends Connection{
        public function getAllData(){
            return [
                "menu" => $this->select('categories', '*', 'show_in_menu = 1', '_order ASC', []),
                "categories" => $this->select('categories', '*', '', 'name ASC', []),
            ];
        }
    }