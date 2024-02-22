<?php require 'View/includes/header.php'?>

<?php // Use any data loaded in the controller here ?>

<section>
    <h1><?= $article->title ?> - By <?= $article->author ?></h1>
    <p><?= $article->formatPublishDate() ?></p>
    <p><?= $article->description ?></p>

    <!--- TODO: links to next and previous -->
    <?php if ($previousArticle): ?>
        <a href="index.php?page=articles-show&articleId=<?= $previousArticle->id ?>">Previous article</a>
    <?php endif; ?>
    
    <?php if ($nextArticle): ?>
        <a href="index.php?page=articles-show&articleId=<?= $nextArticle->id ?>">Next article</a>
    <?php endif; ?>

</section>

<?php require 'View/includes/footer.php'?>