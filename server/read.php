<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");


include_once 'databaseconf.php';
include_once 'facility.php';


// instantiate database and facility object
$database = new Database();
$db = $database->getConnection();
 
// initialize facility object
$facility = new Facility($db);


$queryName=isset($_GET['q'])?trim($_GET['q']):null;
$facilityCode=isset($_GET['code'])?trim($_GET['code']):null;
$status=isset($_GET['status'])?trim($_GET['status']):null;

$stmt = $facility->read($facilityCode);
$numRows = $stmt->rowCount();
 
// check if more than 0 record found
if($numRows>0){
 

    $facilitys_arr=array();
 
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $facility_record=array(
            "code" => $code,
            "name" => html_entity_decode($name),
            "status" => html_entity_decode($status),
            "voided" => $voided,
            "date_created" => $date_created
        );
 
        array_push($facilitys_arr, $facility_record);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show facilitys data in json format
    $outputData= array('data' => $facilitys_arr, 'totalCount' => $numRows);
     echo json_encode($outputData);

}
 