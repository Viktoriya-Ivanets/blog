<?php
session_start();
include_once("models/article.php");
include_once("models/tags.php");
include_once("models/category.php");
include_once("models/auth.php");

$user = authGetUser();
$message = '';
$activeCategoryResults = array();
$activeTagResults = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['search'])) {
        $searchTerms = explode(" ", htmlspecialchars(trim($_POST['search'])));

        foreach ($searchTerms as $term) {
            $tagsResults = searchTag($term);
            $categoryResults = searchCategory($term);
            $articleResults = searchArticle($term);
        }
        foreach ($categoryResults as $categoryResult) {
            changeState($categoryResult['id']);
            $categoryResult = oneCategory($categoryResult['id']);
            if ($categoryResult['state'] === 'active') {
                $activeCategoryResults[] = $categoryResult;
            }
        }
        foreach ($tagsResults as $tagsResult) {
            changeTagState($tagsResult['id']);
            $tagsResult = getTagName($tagsResult['id']);
            if ($tagsResult['state'] === 'active') {
                $activeTagResults[] = $tagsResult;
            }
        }
        if (count($activeTagResults) == 0 && count($articleResults) == 0 && count($activeCategoryResults) == 0) {
            $message = 'No results found';
        }
    } else {
        $message = 'Please enter some phrase to search';
    }
}

include('views/search.php');