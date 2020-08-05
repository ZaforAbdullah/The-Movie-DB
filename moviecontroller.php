<?php

include_once 'dbclass.php';
include_once 'movie.php';

class MovieController{

    private $dbclass;

    public function __construct() {
        $this->dbclass = new DBClass();
    }

    public function getAll(){
        $movie = new Movie($this->dbclass->getConnection());
        $stmt = $movie->read();
        $count = $stmt->rowCount();
        return $count != 0 ? $stmt : false;
    }

    public function search($query){
        $movie = new Movie($this->dbclass->getConnection());
        $stmt = $movie->search($query);
        $count = $stmt->rowCount();
        return $count != 0 ? $stmt : false;
    }

    public function get($id){
        $movie = new Movie($this->dbclass->getConnection());
        $movie->id = $id;
        $movie->readSingle();
        return $movie->title != null ? $movie : false;
    }

    public function delete($id){
        $movie = new Movie($this->dbclass->getConnection());
        $movie->id = $id;
        $res = $movie->delete();
        return $res ? $res : false;
    }

    public function update($id, $parameters){
        $movie = new Movie($this->dbclass->getConnection());
        extract($parameters);
        $movie->id = $id;
        $movie->title = $title;
        $movie->description = $description;
        $movie->url = $url;
        $movie->location = $locatin;
        $res = $movie->update();
        return $res ? $res : false;
    }

    public function create($parameters){
        $movie = new Movie($this->dbclass->getConnection());
        extract($parameters);
        $movie->id = $id;
        $movie->title = $title;
        $movie->description = $description;
        $movie->url = $url;
        $movie->location = $location;
        $res = $movie->create();
        return $res ? $res : false;
    }

}
?>