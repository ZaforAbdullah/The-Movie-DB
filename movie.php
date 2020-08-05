<?php
class Movie{

    // Connection instance
    private $connection;

    // Table name
    private $table_name = "Movie";

    // Table columns
    public $id;
    public $title;
    public $description;
    public $url;
    public $location;

    // DB connection
    public function __construct($connection){
        $this->connection = $connection;
    }

    // CREATE
    public function create(){
        $query = "INSERT INTO ". $this->table_name ."
                    SET
                        id = :id, 
                        title = :title, 
                        description = :description, 
                        url = :url, 
                        location = :location";
    
        $stmt = $this->connection->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->loction=htmlspecialchars(strip_tags($this->location));
    
        // bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":location", $this->location);
    
        if($stmt->execute()){
           return true;
        }
        return false;
    }

    // GET ALL
    public function read(){
        $query = "SELECT id, title, description, url, location FROM " . $this->table_name . "";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // SEARCH
    public function search($param){
        $query = "SELECT id, title, description, url, location FROM " . $this->table_name . " WHERE title LIKE '%" . $param . "%' OR description LIKE '%" . $param . "%' OR url LIKE '%" . $param . "%' OR location LIKE '%" . $param . "%'";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // GET SINGLE
    public function readSingle(){
        $query = "SELECT id, title, description, url, location FROM ". $this->table_name ." WHERE id = ? LIMIT 0,1";

        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->title = $dataRow['title'];
        $this->description = $dataRow['description'];
        $this->url = $dataRow['url'];
        $this->location = $dataRow['location'];
    }

    // UPDATE
    public function update(){
        $query = "UPDATE ". $this->table_name ."
                    SET
                        title = :title, 
                        description = :description, 
                        url = :url, 
                        location = :location
                    WHERE
                        id = :id";
    
        $stmt = $this->connection->prepare($query);
    
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->url=htmlspecialchars(strip_tags($this->url));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind data
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":url", $this->url);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":id", $this->id);
    
        if($stmt->execute()){
           return true;
        }
        return false;
    }

    // DELETE
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->connection->prepare($query);
    
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(1, $this->id);
    
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}