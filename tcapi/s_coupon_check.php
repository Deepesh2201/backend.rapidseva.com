<?php
require dirname(dirname(__FILE__)) . '/include/dbconfig.php';
$data = json_decode(file_get_contents('php://input'), true);

if ($data['userId'] == '') {
    $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Something went wrong!");
}

if ($data['coupon'] == '') {
    $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Enter Coupon Code");
} else {
    $coupon = strip_tags(mysqli_real_escape_string($mysqli, $data['coupon']));


    $chek = $mysqli->query("SELECT * from tbl_coupon where coupon_code = '$coupon'");
    if ($chek->num_rows > 0) {
        $row = $chek->fetch_assoc();
        $couponLimit = $row['user_limit'];
        $couponId = $row['id'];
        $discPer = $row['disc_per'];
        $maxDisc = $row['max_disc'];

        $countQuery = $mysqli->query("SELECT COUNT(tcu.id) AS usage_count
        FROM tbl_coupon tc 
        LEFT JOIN tbl_coupon_usage tcu ON tc.id = tcu.coupon_id
        WHERE tc.coupon_code = '$coupon'
        AND tcu.user_id = '$userId'
        GROUP BY tc.id
        ");
        $countRow = $countQuery->fetch_assoc();
        $usageCount = $countRow['usage_count'];

        if ($usageCount >= $couponLimit) {
            $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Coupon Already Used");
        } else {
            $returnArr = array("ResponseCode" => "200", "Result" => "true", "ResponseMsg" => "Coupon Found", "CouponID" => $couponId, "CouponLimit" => $couponLimit, "DiscPer" => $discPer, "MaxDisc" => $maxDisc, "UsageCount" => $usageCount);
        }
    }
    else{
        $returnArr = array("ResponseCode" => "401", "Result" => "false", "ResponseMsg" => "Invalid Coupon Code");
    }
}
echo json_encode($returnArr);
