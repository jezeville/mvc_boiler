<?php

declare(strict_types = 1);

class ArticleController
{
    public function index()
    {
        // Load all required data
        $articles = $this->getArticles();

        // Load the view
        require 'View/articles/index.php';
    }

    // Note: this function can also be used in a repository - the choice is yours
    private function getArticles()
    {
        // TODO: prepare the database connection
        // Note: you might want to use a re-usable databaseManager class - the choice is yours
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=mvc;charset=utf8', 'root', '');
    
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {             
            die('Error : '.$e->getMessage());
        }
        // TODO: fetch all articles as $rawArticles (as a simple array)
        $stmt = $bdd->query("SELECT * FROM articles");
        $rawArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($rawArticles as $rawArticle) {
            // We are converting an article from a "dumb" array to a much more flexible class
            $articles[] = new Article($rawArticle['id'], $rawArticle['title'], $rawArticle['author'], $rawArticle['description'], $rawArticle['publish_date']);
        }

        return $articles;
    }

    public function show($articleId)
    {
        // TODO: this can be used for a detail page
        $previousArticle = $this->getPreviousArticle($articleId);
        $article = $this->getArticleById($articleId);
        $nextArticle = $this->getNextArticle($articleId);

        require 'View/articles/show.php';
    }

    private function getArticleById($articleId)
    {
        try {
            // Préparer la connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=mvc;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Requête SQL pour récupérer l'article par son identifiant
            $stmt = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
            $stmt->execute([$articleId]);
            $articleData = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($articleData) {
                return new Article($articleData['id'], $articleData['title'], $articleData['author'], $articleData['description'], $articleData['publish_date']);
            } else {
                return null; // Aucun article trouvé avec cet identifiant
            }
        } catch(PDOException $e) {
            die('Error : '.$e->getMessage());
        }
    }

    private function getPreviousArticle($articleId)
    {
        try {
            // Préparer la connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=mvc;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Requête SQL pour récupérer l'article précédent
            $stmt = $bdd->prepare("SELECT * FROM articles WHERE id < ? ORDER BY id DESC LIMIT 1");
            $stmt->execute([$articleId]);
            $previousArticle = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($previousArticle) {
                return new Article($previousArticle['id'], $previousArticle['title'], $previousArticle['author'], $previousArticle['description'], $previousArticle['publish_date']);
            } else {
                return null; // Aucun article précédent trouvé
            }
        } catch(PDOException $e) {
            die('Error : '.$e->getMessage());
        }
    }

    private function getNextArticle($articleId)
    {
        try {
            // Préparer la connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=mvc;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Requête SQL pour récupérer l'article suivant
            $stmt = $bdd->prepare("SELECT * FROM articles WHERE id > ? ORDER BY id ASC LIMIT 1");
            $stmt->execute([$articleId]);
            $nextArticle = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($nextArticle) {
                return new Article($nextArticle['id'], $nextArticle['title'], $nextArticle['author'], $nextArticle['description'], $nextArticle['publish_date']);
            } else {
                return null; // Aucun article suivant trouvé
            }
        } catch(PDOException $e) {
            die('Error : '.$e->getMessage());
        }
    }

    public function getUrl()
    {
        return '/article/' . $this->id;
    }
}