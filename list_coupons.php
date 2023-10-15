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
                <h1>Coupons List</h1>
            </div>
            <div class="col-md-3 col-lg-3 col-xs-12">
                <a href="add_coupon.php" class="btn btn-primary"> Add New Coupon </a>
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
                                <th>Coupon Name</th>
                                <th>Coupon Code</th>
                                <th>Discount %</th>
                                <th>Max Discount</th>
                                <th>Limit</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Coupon Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $mysqli->query("SELECT * FROM `tbl_coupon`");
                            $i = 0;
                            while ($row = $stmt->fetch_assoc()) {
                                $i = $i + 1;
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td> <?php echo $row['coupon_title']; ?></td>
                                    <td> <?php echo $row['coupon_code']; ?></td>
                                    <td> <?php echo $row['disc_per']; ?></td>
                                    <td> <?php echo $row['max_disc']; ?></td>
                                    <td> <?php echo $row['user_limit']; ?></td>
                                    <td> <?php echo $row['start_date']; ?></td>
                                    <td> <?php echo $row['end_date']; ?></td>
                                    <?php if ($row['coupon_status'] == 1) { ?>
                                        <td>
                                            <div class="badge badge-success">Publish</div>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <div class="badge badge-danger">Unpublish</div>
                                        </td>
                                    <?php } ?>




                                    <td><a href="add_coupon.php?id=<?php echo $row['id']; ?>" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                        <a href="?did=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                    </td>
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