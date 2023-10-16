<?php 
require dirname( dirname(__FILE__) ).'/include/dbconfig.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['coupon'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Coupon Not Provided");
}
else
{
    $coupon = strip_tags(mysqli_real_escape_string($mysqli,$data['coupon']));
    
    
$chek = $mysqli->query("select * from tbl_coupon where coupon_code ='".$coupon."'")->num_rows;

if($chek != 0)
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Coupon Found!");
}
else 
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Coupon Not Found");
}
}
echo json_encode($returnArr);