<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once 'databaseconf.php';
 
// Include facility object
include_once 'facility.php';
include_once 'mflcodegenerator.php';

// Exit processing of facility data if the method is not post
 if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
  }

$database = new Database();
$db = $database->getConnection();

// get posted data
$data = json_decode(file_get_contents("php://input"));


if(isset($_POST["name"]) && isset($_POST["status"])){
$name=trim($_POST["name"]);
$status=trim($_POST["status"]);
} else{

$name=$data->name;
$status=$data->status;
}




$voided=0;


// make sure required data is captured
if(
    !empty($name) &&
    !empty($status)
){

    $facility = new Facility($db);
    $mflcodeGenerator = new MFLcodeGenerator($db);

   $newFacilityNamePart= substr(strtoupper($name),0,3);
    $code=$mflcodeGenerator->createNewCode($newFacilityNamePart);

    $facility->code = $code;
    $facility->name = $name;
    $facility->status = $status;
    $facility->voided = $voided;

  // Set time zone to avoid conflicts
    date_default_timezone_set('Africa/Nairobi');
    $currentDate=date('Y-m-d h:i:s a', time());
    $facility->date_created =  $currentDate;
    
    $recordExists=$facility->searchFacilityByName($name);

    // create the facility


    if($recordExists==0){

                if($facility->create()){

                    // set response code - 201 created
                    http_response_code(201);

                    // tell the user
                    echo json_encode(array("success" => "Facility Created"));
                }

                // if unable to create the facility, tell the user
                else{

                    // set response code - 503 service unavailable
                    http_response_code(503);

                    // tell the user
                    echo json_encode(array("error" => "Unable to Add Facility"));
                }

    }

    // if the facility name exists, tell the user
    else {
                        http_response_code(200);

                        echo json_encode(array("error" => "Facility Already Exists"));

     }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("error" => "Unable to Add Facility. Data is incomplete."));
}
?>