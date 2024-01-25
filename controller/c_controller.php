<?php


/*
* Nom : controller.php
* Auteur : Sam Freddi 
* Date : 06.09.2023
* Version : 1.0
* Description : Page controller du site
*/

require_once './modele/db/database.php';

if (!isset($_GET['page'])) {
    require_once './vue/page/home.php';
}
if (isset($_GET['page'])) {
    $name = htmlspecialchars($_GET["page"]);
    switch ($name) {
        case 'home':
            require_once './controller/c_display.php';
            require_once './vue/page/home.php';
            break;
        case 'post':
            require_once './controller/c_post.php';
            require_once './vue/page/post.php';
            break;
    
    }
}


