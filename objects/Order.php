<?php
// 'oder' object
class Order{
 
    // database connection and table name
    private $conn;
    private $table_name = "orders";
 
    //order object properties
    public $id;
    public $name;
    public $status;
   
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
    // create new oder record
    function create(){
    
        // insert query
        $query = "INSERT INTO " . $this->table_name . " SET  name = :name,status = :status";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // data cleaning
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->status=htmlspecialchars(strip_tags($this->status));
    
        // bind the values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':status', $this->status);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function read(){
        //sql query
        $query = "SELECT id,name, status FROM $this->table_name ORDER BY id ASC";

        ///prepare the query
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;
    }

    function singleOrder(){
        //$sql query
        $query = "SELECT id,name, status
        FROM $this->table_name WHERE id=? LIMIT 0,1";

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //bind parameters
        $stmt->bindParam(1, $this->id);

        //execute the query
        $stmt->execute();

        $row = $stmt->fetch(PDO:: FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->status = $row['status'];

    }

    function markDelivered(){
        // insert query
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // data cleaning
        $this->status=htmlspecialchars(strip_tags($this->status));
    
        // bind the values
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function update(){
        // insert query
        $query = "UPDATE " . $this->table_name . "
        SET name = :name,
        status = :status
        WHERE id = :id";
    
        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // data cleaning
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->status=htmlspecialchars(strip_tags($this->status));
    
        // bind the values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        // execute the query, also check if query was successful
        try {
            $stmt->execute();
            return true;    
        } catch (Exception $e) {
            $e->getMessage();          
            return false;
        }
       
    }


    function delete(){
        // insert query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        // prepare the query
        $stmt = $this->conn->prepare($query);
    
        // data cleaning
        $this->status=htmlspecialchars(strip_tags($this->id));
    
        // bind the values
        $stmt->bindParam(':id', $this->id);
        
        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
}