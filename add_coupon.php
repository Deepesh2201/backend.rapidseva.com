<?php
require 'include/navbar.php';
require 'include/sidebar.php';
?>
<!-- Start main left sidebar menu -->

<?php
if (isset($_POST['addcoupon'])) {
    $coupon_code = mysqli_real_escape_string($mysqli, $_POST['coupon_code']);
    $coupon_title = $_POST['coupon_title'];
    $disc_per = $_POST['disc_per'];
    $max_disc = $_POST['max_disc'];
    $user_limit = $_POST['user_limit'];
    // $start_date = $_POST['start_date'];
    // $end_date = $_POST['end_date'];
	$start_date = date('Y-m-d\TH:i', strtotime($_POST['start_date']));
	$end_date = date('Y-m-d\TH:i', strtotime($_POST['end_date']));
    $coupon_status = $_POST['coupon_status'];

    $table = "tbl_coupon";
    $field_values = array("coupon_title", "coupon_code", "disc_per", "max_disc", "user_limit", "start_date", "end_date", "coupon_status");
    $data_values = array("$coupon_title", "$coupon_code", "$disc_per", "$max_disc", "$user_limit", "$start_date", "$end_date", "$coupon_status");

    $errors = array();

    // Check for mandatory fields
    if (empty($coupon_code) || empty($coupon_title) || empty($disc_per) || empty($max_disc) || empty($user_limit) || empty($start_date) || empty($end_date) || empty($coupon_status)) {
        $errors[] = 'All fields are mandatory.';
    }

    // Check if coupon_code is unique
    $query = "SELECT * FROM $table WHERE coupon_code = '$coupon_code'";
    $result = mysqli_query($mysqli, $query);
    $existing_coupon = mysqli_fetch_assoc($result);

    if ($existing_coupon) {
        $errors[] = 'Coupon Code already exists. Please choose a different code.';
    }

    if (empty($errors)) {
        $h = new Common();
        $check = $h->InsertData($field_values, $data_values, $table);
        if ($check == 1) {
            $msg = 'Coupon Added Successfully!!';
            echo "<meta http-equiv='refresh' content='3'>";
        }
    } else {
        // // Display error messages
        // foreach ($errors as $error) {
        //     echo '<div class="alert alert-danger">' . $error . '</div>';
        // }
    }
}
?>

<?php
if (isset($_POST['updatecoupon'])) {
	
    $coupon_code = mysqli_real_escape_string($mysqli, $_POST['coupon_code']);
    $coupon_title = $_POST['coupon_title'];
    $disc_per = $_POST['disc_per'];
    $max_disc = $_POST['max_disc'];
    $user_limit = $_POST['user_limit'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $coupon_status = $_POST['coupon_status'];
    $table = "tbl_coupon";
    $field_values = array(
        "coupon_title",
        "coupon_code",
        "disc_per",
        "max_disc",
        "user_limit",
        "start_date",
        "end_date",
        "coupon_status"
    );
    $data_values = array(
        "$coupon_title",
        "$coupon_code",
        "$disc_per",
        "$max_disc",
        "$user_limit",
        "$start_date",
        "$end_date",
        "$coupon_status"
    );

    $errors = array();

    // Check for mandatory fields
    if (empty($coupon_code) || empty($coupon_title) || empty($disc_per) || empty($max_disc) || empty($user_limit) || empty($start_date) || empty($end_date) || empty($coupon_status)) {
		$errors[] = 'All fields are mandatory.';
    }
	
    // Check if coupon_code is unique (excluding the current coupon ID)
    $upid = $_GET['id'];
    $query = "SELECT * FROM $table WHERE coupon_code = '$coupon_code' AND id != $upid";
    $result = mysqli_query($mysqli, $query);
    $existing_coupon = mysqli_fetch_assoc($result);
	
    if ($existing_coupon) {
		$errors[] = 'Coupon Code already exists. Please choose a different code.';
    }
	else{
		
		
		if (empty($errors)) {
			// Define the WHERE condition for the update
			
			$field = array('coupon_title'=>$coupon_title,'coupon_code'=>$coupon_code,'disc_per'=>$disc_per,'max_disc'=>$max_disc,'user_limit'=>$user_limit,'start_date'=>$start_date,'end_date'=>$end_date,'coupon_status'=>$coupon_status);
			$where = "where id=".$_GET['id']."";
		  $h = new Common();
				$check = $h->UpdateData($field,$table,$where);
			// echo "Query:Query:Query:Query:Query:Query:ry:Query:Query:Query:Query:Query:Query:Query::Query:Query:Query: " . $where . "<br>";
        if ($check == 1) {
            $msg = 'Coupon Updated Successfully!!';
            echo "<meta http-equiv='refresh' content='3'>";
        }
    }
	
	}
	
}
?>


<!-- Start app main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<?php
			if (isset($_GET['id'])) {
			?>
				<h1>Update Coupon</h1>
			<?php
			} else {
			?>
				<h1>Add Coupon</h1>
			<?php } ?>
		</div>

		<div class="card">
		<div class="error-messages">
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
    }
    ?>
</div>
			<?php
			if ($msg != '') {
			?>
				<div class="alert alert-success alert-dismissible show fade">
					<div class="alert-body">
						<button class="close" data-dismiss="alert"><span>×</span></button>
						<?php echo $msg; ?>
					</div>
				</div>
			<?php } ?>
			<?php
			if (isset($_GET['id'])) {
				$data = $mysqli->query("select * from tbl_coupon where id=" . $_GET['id'] . "")->fetch_assoc();
				// For start_date
				$start_date = date('Y-m-d\TH:i', strtotime($data['start_date']));

				// For end_date
				$end_date = date('Y-m-d\TH:i', strtotime($data['end_date']));

			?>
			<form method="post" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-md-12">
								<label>Coupon Title</label><span style="color: red;">*</span>
								<input type="text" class="form-control" placeholder="Enter Coupon Title" value="<?php echo $data['coupon_title']; ?>" name="coupon_title" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label>Coupon Code</label><span style="color: red;">*</span>
								<input type="text" class="form-control" placeholder="Enter Coupon Code" value="<?php echo $data['coupon_code']; ?>" name="coupon_code" required>
							</div>
							<div class="col-md-3">
								<label>Discount %</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Enter Discount %" value="<?php echo $data['disc_per']; ?>" name="disc_per" required>
							</div>
							<div class="col-md-3">
								<label>Max Discount(Amount)</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Mximum discount amount" value="<?php echo $data['max_disc']; ?>" name="max_disc" required>
							</div>
							<div class="col-md-3">
								<label>User Limit(-1 for unlimited)</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Usage per user/customer" value="<?php echo $data['user_limit']; ?>" name="user_limit" required>
							</div>
						</div>
						<div class="form-group row">



							<div class="col-md-3">
								<label>Start Date</label><span style="color: red;">*</span>
								<!-- <input type="datetime-local" class="form-control" placeholder="Select Start Date" value="<?php echo $data['start_date']; ?>" name="start_date" required> -->
								<input type="datetime-local" class="form-control" value="<?php echo $start_date; ?>" name="start_date" required>
							</div>
							<div class="col-md-3">
								<label>End Date</label><span style="color: red;">*</span>
								<!-- <input type="datetime-local" class="form-control" placeholder="Select End Date" value="<?php echo $data['end_date']; ?>" name="end_date" required> -->
								<input type="datetime-local" class="form-control" value="<?php echo $end_date; ?>" name="end_date" required>
							</div>
							<div class="col-md-3">
								<label>Coupon Status</label><span style="color: red;">*</span>
								<select name="coupon_status" class="form-control">
								<option value="1" <?php if ($data['coupon_status'] == 1) {
														echo 'selected';
													} ?>>Publish</option>
								<option value="0" <?php if ($data['coupon_status'] == 0) {
														echo 'selected';
													} ?>>UnPublish</option>
							</select>
							</div>
						</div>

					</div>
					<div class="card-footer text-left">
						<button name="updatecoupon" class="btn btn-primary">Update Coupon</button>
					</div>
				</form>
				
			<?php
			} else {
			?>
				<form method="post" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-group row">
							<div class="col-md-12">
								<label>Coupon Title</label><span style="color: red;">*</span>
								<input type="text" class="form-control" placeholder="Enter Coupon Title" name="coupon_title" required>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3">
								<label>Coupon Code</label><span style="color: red;">*</span>
								<input type="text" class="form-control" placeholder="Enter Coupon Code" name="coupon_code" required>
							</div>
							<div class="col-md-3">
								<label>Discount %</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Enter Discount %" name="disc_per" required>
							</div>
							<div class="col-md-3">
								<label>Max Discount(Amount)</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Mximum discount amount" name="max_disc" required>
							</div>
							<div class="col-md-3">
								<label>User Limit(0 = unlimited)</label><span style="color: red;">*</span>
								<input type="number" class="form-control" placeholder="Usage per user/customer" name="user_limit" required>
							</div>
						</div>
						<div class="form-group row">



							<div class="col-md-3">
								<label>Start Date</label><span style="color: red;">*</span>
								<input type="datetime-local" class="form-control" placeholder="Select Start Date" name="start_date" required>
							</div>
							<div class="col-md-3">
								<label>End Date</label><span style="color: red;">*</span>
								<input type="datetime-local" class="form-control" placeholder="Select End Date" name="end_date" required>
							</div>
							<div class="col-md-3">
								<label>Coupon Status</label><span style="color: red;">*</span>
								<select name="coupon_status" class="form-control">
									<option value="1">Publish</option>
									<option value="0">Unpublish</option>
								</select>
							</div>
						</div>

					</div>
					<div class="card-footer text-left">
						<button name="addcoupon" class="btn btn-primary">Add Coupon</button>
					</div>
				</form>

			<?php } ?>
		</div>
</div>


</section>
</div>


</div>
</div>

<?php require 'include/footer.php'; ?>


</body>


</html>