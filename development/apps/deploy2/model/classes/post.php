<?php

namespace model\classes;
class Post
{
    private ?string $id = null;
    private ?string $title = null;
    private ?string $text = null;
    private ?array $attachment = null;

    function getId():?string{
        return $this->id;
    }
    function setId($id){
        $this->id=$id;
    }

    function getTitle():?string{
        return $this->title;
    }
    function setTitle($newTitle){
        $this->title = $newTitle;
    }

    function getText():?string{
        return $this->text;
    }
    function setText($newText){
        $this->text=$newText;
    }

    function getAttachment():?array{
        return $this->attachment;
    }
    function setAttachment($newAttachment){ 
        $this->attachment=$newAttachment;
    }

    function toString():?string{
        if(empty($this->title) && empty($this->text))
            return null;
        
        $post = '';
        if(!empty($this->title))
            $post = "*".$this->title."*\n";
            
        if(!empty($this->text))
            $post = $post . $this->text;

        return $post;
    }
}
