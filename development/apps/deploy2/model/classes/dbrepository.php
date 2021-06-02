<?php

namespace model\classes;
class DBRepository{
    function get($id) {
        include 'db.php';
        $post = new Post();
        $dbResponse = $dbConnection->query("SELECT * FROM telegram_post WHERE id = '$id'");
        while ($row = $dbResponse ->fetch())
        {
             $post ->setTitle($row['title']);
             $post ->setText($row['text']);
             $post ->setId($row['ChatId']);
        }  
        return $post;
    }

    function add($Post) {
       include 'db.php';
        $text = $Post->getText();
        $title = $Post->getTitle();
        $chatId = $Post->getId();
        $dbConnection->query("INSERT INTO telegram_post (id,title,text,ChatId) VALUES (UUID(),'$title','$text','$chatId')");
    }

    function delete($id) {
        include 'db.php';
        $dbConnection->query("DELETE FROM telegram_post  WHERE id = '$id'");
    }
    function deleteAll() {
        include 'db.php';
        $dbConnection->query("DELETE  FROM telegram_post");
    }
}