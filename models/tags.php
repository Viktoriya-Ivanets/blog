<?php

	include_once('core/db.php');

    function getTagsId(int $id){
        $sql = "SELECT tag_id FROM article_tags WHERE article_id = :id";
        $query = dbQuery($sql, ['id' => $id]);
		return $query->fetchAll();
    }

    function getTagName(int $id){
        $sql = "SELECT header FROM tags WHERE id = :id";
        $query = dbQuery($sql, ['id' => $id]);
        return $query->fetchAll();
    }
    
    function getTagNamesForArticle(int $article_id) {
        $tag_ids = getTagsId($article_id);
        $tag_names = [];
        foreach ($tag_ids as $tag_id) {
            $tag_name = getTagName($tag_id['tag_id']);
            $tag_info = [
                'id' => $tag_id['tag_id'],
                'header' => $tag_name[0]['header']
            ];
            $tag_names[] = $tag_info;
        }
    
        return $tag_names;
    }

    function getArticlesByTag(int $tag_id) {
        $sql = "SELECT article.id, article.header, article.state FROM article
                JOIN article_tags ON article.id = article_tags.article_id
                JOIN tags ON article_tags.tag_id = tags.id
                WHERE tags.id = :tag_id";
    
        $query = dbQuery($sql, ['tag_id' => $tag_id]);
        return $query->fetchAll();
    }
    
    function addTag(string $header) {
        $sql = "INSERT INTO tags (header) VALUES (:header) ON DUPLICATE KEY UPDATE header = :header";
        dbQuery($sql, ['header' => $header]);
        return true;
    }

    function removeTagsForArticle(int $id) {
        $sql = "DELETE FROM article_tags WHERE article_id = :id";
        $query = dbQuery($sql, ['id' => $id]);
        return true;
    }

    function getAllTags() {
        $sql = "SELECT * FROM tags";
		$query = dbQuery($sql);
		return $query->fetchAll();
    }
    
    function linkArticleWithTag(int $articleId, int $tagId) {
        $params = ['article_id' => $articleId, 'tag_id' => $tagId];
        $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id) 
                ON DUPLICATE KEY UPDATE article_id=article_id";
        dbQuery($sql, $params);
        return true;
    }    

    function getTagId(string $header) {
        $sql = "SELECT id FROM tags WHERE header =:header";
		$query = dbQuery($sql, ['header' => $header]);
		return $query->fetch();
    }