<?php

declare(strict_types=1);

class Article
{
    public $id;
    public $title;
    public $author;
    public $description;
    public $publishDate;

    public function __construct($id, $title, $author, $description, $publishDate)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
        $this->publishDate = $publishDate;
    }

    public function formatPublishDate($format = 'd M Y')
    {
        // TODO: return the date in the required format
        $publishDateTime = new DateTime($this->publishDate);

        return $publishDateTime->format($format);
    }
}