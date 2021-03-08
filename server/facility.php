<?php

class Facility{
 
    // database connection and table name
    private $conn;
    private $table_name = "mfl_facility";
 
    // object properties
    public $code;
    public $name;
    public $status;
    public $voided;
    public $date_created;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

  
// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
            " . $this->table_name . "
            SET 
            code=:code, 
            name=:name,
            status=:status,
            voided=:voided,
            date_created=:date_created
            ";
             
    $stmt = $this->conn->prepare($query);
         
    // set facility properties
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->voided=htmlspecialchars(strip_tags($this->voided));
    $this->status=htmlspecialchars(strip_tags($this->status));

 
    // bind values
    $stmt->bindParam(":code", $this->code);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":status", $this->status);
    $stmt->bindParam(":voided", $this->voided);
    $stmt->bindParam(":date_created", $this->date_created);

    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}


function  searchFacilityByCode($code){

    $query = " SELECT code  from mfl_facility ".
    "where code like '$code' ";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->rowCount();
    
}

function searchFacilityByName($name){

    $query = " SELECT code  from mfl_facility  ".
    " where   name  like '$name'";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
   return $stmt->rowCount();

}


function read(){
 
    // create search criteria

    $custSearch=$this->getCurstomSearch();

    $query = ' SELECT   * from mfl_facility where voided <>1';

    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();

    return $stmt;
    
}

function voidFacility($facilityCode){

    date_default_timezone_set('Africa/Nairobi');
    $currentDate=date('Y-m-d h:i:s a', time());

    $query = " update mfl_facility set voided=1,date_voided='$currentDate' where code like '$facilityCode' ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;

}

function updateFacility($facilityCode,$name,$status){

    $query = " update mfl_facility set name='$name',status='$status' where code like '$facilityCode' ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;

}


function getCurstomSearch(){

    $queryName=isset($_GET['q'])?trim($_GET['q']):null;

    $status=isset($_GET['status'])?trim($_GET['status']):null;


    return null;
}

}