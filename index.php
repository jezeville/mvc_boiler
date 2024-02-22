<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//include all your model files here
require 'Model/Article.php';
//include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';

// Get the current page to load
// If nothing is specified, it will remain empty (home should be loaded)
$page = $_GET['page'] ?? null;

// Load the controller
// It will *control* the rest of the work to load the page
switch ($page) {
    case 'articles-index':
        // This is shorthand for:
        // $articleController = new ArticleController;
        // $articleController->index();
        (new ArticleController())->index();
        break;
    case 'articles-show':
        // TODO: detail page
        $articleId = $_GET['articleId'] ?? null;
        if ($articleId !== null) {
            (new ArticleController())->show($articleId);
        } else {
            // If articleId is not provided, redirect to homepage or handle the error
            header('Location: index.php');
            exit();
        }
        break;
    case 'home':
    default:
        (new HomepageController())->index();
        break;
}