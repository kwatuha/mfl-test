<?php

class MFLcodeGenerator{
 
    // database connection
    private $conn;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }



function  getCodesStartingWith($partialname){

    $query = " SELECT count(*) as similarcodes  from mfl_facility where name like '$partialname%'" ;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    
}

function createNewCode($searchOption){

    $stmt =$this -> getCodesStartingWith($searchOption);
     $results=$stmt->fetch(PDO::FETCH_ASSOC);
     $newNumericComponent=$results["similarcodes"]+1;
     $numericComponent=$this->paddingZeros($newNumericComponent, 8);


     return $searchOption. $numericComponent;
}

function paddingZeros($value, $places){

   $leading="";

    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}

}