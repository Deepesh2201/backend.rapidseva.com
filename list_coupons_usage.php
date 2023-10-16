<?php
require 'include/navbar.php';
require 'include/sidebar.php';
?>
<!-- Start main left sidebar menu -->
<?php
if (isset($_GET['did'])) {
    $id = $_GET['did'];

    $table = "tbl_coupon";
    $where = "where id=" . $id . "";
    $h = new Common();
    $check = $h->Deletedata($where, $table);

    if ($check == 1) {
        $msg = 'Coupon Delete Successfully!!';
        echo "<meta http-equiv='refresh' content='3'>";
    }
}
?>

<!-- Start app main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="col-md-9 col-lg-9 col-xs-12">
                <h1>Coupons Usage List</h1>
            </div>
        </div>
        <div class="card">
            <?php
            if ($msg != '') {
            ?>
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>×</span></button>
                        <?php echo $msg; ?>
                    </div>
                </div>
            <?php } ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped v_center" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>Coupon Code</th>
                                <th>Customer Name</th>
                                <th>Customer Mobile</th>
                                <th>Discount Amount</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $stmt = $mysqli->query("SELECT * FROM `tbl_coupon_usage`");
                            $stmt = $mysqli->query("SELECT cu.discount_amt, cu.created_at, c.coupon_code, u.name, u.mobile
                            FROM tbl_coupon_usage cu
                            JOIN tbl_coupon c ON c.id = cu.coupon_id
                            JOIN tbl_user u ON u.id = cu.user_id;
                            ");
                            $i = 0;
                            while ($row = $stmt->fetch_assoc()) {
                                $i = $i + 1;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td> <?php echo $row['coupon_code']; ?></td>
                                    <td> <?php echo $row['name']; ?></td>
                                    <td> <?php echo $row['mobile']; ?></td>
                                    <td> <?php echo $row['discount_amt']; ?></td>
                                    <td> <?php echo $row['created_at']; ?></td>
                                   
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>


</section>
</div>


</div>
</div>

<?php require 'include/footer.php'; ?>


</body>


</html>