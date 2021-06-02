<?php
namespace Model\Classes;
/*
Так чтобы не забыть. Нам надо по хорошему отделить в запросе ссылку на фотку и на файл для нашего запроса
Следовательно нужно новое поле в классах)
И гет/сет
*/
class InstagramPost implements iPost{

    private $id;
    private $title;
    private $date;
    private $text;
    private $attachment;
    private $geo;
    private $hashtags;

    private function __constructor(?String $title, ?String $text, $attachment, ?String $geo, String|Array $hashtags = null, String  $date = null){
        //generate id from database
        $this->$title = $title;
        $this->$text = $text;
        $this->$attachment = $attachment;
        $this->$geo = $geo;
        $this->$hashtags = $hashtags;
        if(is_null($date)){
            $this->$date = date('l jS \of F Y h:i:s A');
        }else{
            $this->$date = $title;
        }
    }

    public static function search(?String $title, ?String $text, $attachment, ?String $geo, String|Array $hashtags = null, String  $date = null):self|null {
        $class = __CLASS__
        return new $class($title, $text, $attachment, $geo, $hashtags, $date);
    }


    public function save(){

    }


    public function publish(){}


    public function delete(){}


    public function edit(){}


    public function schedulePublish(){}


    public function getId(){
        return $this->$id;
    }


    public function setId($id){
        $this->$id = $id;
    }


    public function getTitle(){
        return $this->$title;
    }


    public function setTitle($title){
        $this->$title = $title;
    }


    public function getDate(){
        return $this->$date;
    }


    public function setDate($date){
        $this->$date = $date;
    }


    public function getText(){
        return $this->$text;
    }


    public function setText($text){
        $this->$text = $text;
    }


    public function getAttachment(){
        return $this->$attachment;
    }


    public function setAttachment($attachment){
        $this->$attachment = $attachment;
    }

}