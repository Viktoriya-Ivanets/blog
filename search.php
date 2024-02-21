<?php
include_once("init.php");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['search'])) {
        $searchTerms = explode(" ", htmlspecialchars(trim($_POST['search'])));

        foreach ($searchTerms as $term) {
            $tagsResults = searchTag($term);
            $categoryResults = searchCategory($term);
            $articleResults = searchArticle($term);
        }
        if (count($tagsResults) == 0 && count($articleResults) == 0 && count($categoryResults) == 0) {
            $message = 'No results found';
        }
    } else {
        $message = 'Please enter some phrase to search';
    }
}

include('views/search.php'); 