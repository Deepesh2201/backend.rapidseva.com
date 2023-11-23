<?php 
require dirname( dirname(__FILE__) ).'/include/dbconfig.php';
require dirname( dirname(__FILE__) ).'/include/Common.php';
$data = json_decode(file_get_contents('php://input'), true);
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

function saveImageAndGetPath($imageData, $uploadDir)
{
    // Check if the directory exists, create it if not
    if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Extract the base64 data from the string
    list($type, $data) = explode(';', $imageData);
    list(, $data) = explode(',', $data);

    // Decode the base64-encoded image data
    $imageData = base64_decode($data);

    if (!$imageData) {
        die('Failed to decode image data.');
    }

    // Generate a unique filename
    $uniqueFilename = uniqid() . '.jpg'; // You can modify the extension as needed

    // Create the full path to save the file
    $imagePath = $uploadDir . '/' . $uniqueFilename;

    // Save the decoded image data to the specified path
    if (!file_put_contents($imagePath, $imageData)) {
        die('Failed to save image data to file.');
    }

    return $uniqueFilename;
}


if($data['name'] == '' or $data['email'] == '' or $data['mobile'] == ''   or $data['password'] == '' or $data['ccode'] == '' or $data['city'] == '' or $data['address'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    
    $name = strip_tags(mysqli_real_escape_string($mysqli,$data['name']));
    $email = strip_tags(mysqli_real_escape_string($mysqli,$data['email']));
    $mobile = strip_tags(mysqli_real_escape_string($mysqli,$data['mobile']));
	$ccode = strip_tags(mysqli_real_escape_string($mysqli,$data['ccode']));
     $password = strip_tags(mysqli_real_escape_string($mysqli,$data['password']));
	 $city = strip_tags(mysqli_real_escape_string($mysqli,$data['city']));
	 $address = strip_tags(mysqli_real_escape_string($mysqli,$data['address']));
	 $accountNumber = strip_tags(mysqli_real_escape_string($mysqli,$data['accountNumber']));
	 $accountHolder = strip_tags(mysqli_real_escape_string($mysqli,$data['accountHolder']));
	 $ifscCode = strip_tags(mysqli_real_escape_string($mysqli,$data['ifscCode']));
	 $bankName = strip_tags(mysqli_real_escape_string($mysqli,$data['bankName']));
    //  $aadharFrontImage = strip_tags(mysqli_real_escape_string($mysqli, $data['aadharFrontImage']));
    //  $aadharBackImage = strip_tags(mysqli_real_escape_string($mysqli, $data['aadharBackImage']));
    //  $panCardImage = strip_tags(mysqli_real_escape_string($mysqli, $data['panCardImage']));
    //  $localAddressImage = strip_tags(mysqli_real_escape_string($mysqli, $data['localAddressImage']));
    // Define the directory where you want to store the images
    $uploadDir = 'assets/';

    // Check if the directory exists, create it if not
    if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

// Use the saveImageAndGetPath function
$aadharFrontImage = saveImageAndGetPath(file_get_contents($data['aadharFrontImage']), $uploadDir);
$aadharBackImage = saveImageAndGetPath(file_get_contents($data['aadharBackImage']), $uploadDir);
$panCardImage = saveImageAndGetPath(file_get_contents($data['panCardImage']), $uploadDir);
$localAddressImage = saveImageAndGetPath(file_get_contents($data['localAddressImage']), $uploadDir);




     
    
     
    $checkmob = $mysqli->query("select * from partner where mobile=".$mobile."");
    $checkemail = $mysqli->query("select * from partner where email='".$email."'");
   
    if($checkmob->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Mobile Number Already Used!");
    }
     else if($checkemail->num_rows != 0)
    {
        $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Email Address Already Used!");
    }
    else
    {
       
	   
	     $timestamp = date("Y-m-d H:i:s");
		   
		   $table="partner";
  $field_values=array("name","email","mobile","rdate","password","ccode","city","address","bank_account_number","account_holder_name","bank_ifsc_code","bank_name","aadhar_front_image","aadhar_back_image","pan_card_image","local_address_image");
  $data_values=array("$name","$email","$mobile","$timestamp","$password","$ccode","$city","$address","$accountNumber","$accountHolder","$ifscCode","$bankName","$aadharFrontImage","$aadharBackImage","$panCardImage","$localAddressImage");
   $h = new Common();
	  $check = $h->InsertData_Api_Id($field_values,$data_values,$table);
  $c = $mysqli->query("select * from partner where id=".$check."")->fetch_assoc();
  $returnArr = array("PartnerLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>$aadharBackImage);
  
	   
    
}
}

echo json_encode($returnArr);