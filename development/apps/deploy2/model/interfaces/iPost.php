<?php
namespace interface;
interface iPost
{
    public function __construct();
    public static function search();


    public function save();


    public function publish();


    public function delete($id);


    public function edit();


    public function getId();


    public function setId($id);


    public function getTitle();


    public function setTitle($title);


    public function getText();


    public function setText($text);


    public function getAttachment();


    public function setAttachment($attachment);

}