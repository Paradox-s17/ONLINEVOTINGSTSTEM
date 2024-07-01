<?php
	require_once("admin/inc/config.php");

	$fetchingElections = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($DB));

	while($data = mysqli_fetch_assoc($fetchingElections))
	{
		$starting_date = $data['starting_date'];
		$ending_date = $data['ending_date'];
		$curr_date = date("Y-m-d");
		$election_id = $data['id'];
		$status = $data['status'];

		if($status == "Active")
		{
			$date1= date_create($curr_date);
			$date2 = date_create($ending_date);
			$diff = date_diff($date1,$date2);

			if((int)$diff->format("%R%a")< 0)
			{
				//update
				mysqli_query($db, "UPDATE elections SET status = 'Expired' WHERE id ='".$election_id."'") or die(mysqli_error($db));
			}
			
		}else if($status == "inactive")
		{
			$date1= date_create($curr_date);
			$date2 = date_create($starting_date);
			$diff = date_diff($date1,$date2);
			
			if((int)$diff->format("%R%a")<= 0)
			{
				//update
				mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id ='".$election_id."'") or die(mysqli_error($db));
			}
		}else if($status == "Expired")
		{
			$date1= date_create($curr_date);
			$date2 = date_create($ending_date);
			$diff = date_diff($date1,$date2);
			
			if((int)$diff->format("%R%a")> 0)
			{
				//update
				mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id ='".$election_id."'") or die(mysqli_error($db));
			}
		}
        
	}

?>



<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<tittle></title>
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/bootstrapmin.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Online Voting</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>

			<?php
				if(isset($_GET['sign-up']))
				{
			?>
			 <!-- for sign up -->
				<div class="card-body">
						<form method="POST">
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" name="su_username" class="form-control" placeholder="username" required/>
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas  fa-address-book"></i></span>
								</div>
								<input type="digit" name="su_contact_no" class="form-control" placeholder="contact no" required/>
								
							</div>

							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="su_password" class="form-control" placeholder="password" required/>
							</div>

							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="retype_password" class="form-control" placeholder="Re-enter password">
							</div>
							<div class="form-group">
								<input type="submit"  name="sign_up_btn" value="Sign Up" class="btn float-right login_btn">
							</div>
						</form>
					</div>
					<div class="card-footer  text-center my-3">
						
						<?php
							if(isset($_GET['registered']))
							{
						?>
							<span class="bg-white text-success "> Your account has been created successfully!</span>
						<?php		
							} else if(isset($_GET['invailid'])) {
						?>
								<span class="bg-white text-danger"> Password missmatch. Please try again!</span>
						<?php 
							} else if(isset($_GET['not_registered'])) {
						?>
								<span class="bg-white text-warning"> Sorry, you are not registered!</span>
						<?php 
							}
						?>
						<div class="d-flex justify-content-center links">
							Already have account?<a href="?index.php">Sign In</a>
						</div>
					</div>
			<?php
				}
			
				else {
			?>
					<!-- for sign in  -->
					<div class="card-body">
						<form method="POST">
							<div class="input-group form-group">
							<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas  fa-address-book"></i></span>
								</div>
								<input type="text" name="contact_no" class="form-control" placeholder="Contact no" required />
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="password" class="form-control" placeholder="password" required />
							</div>
							<div class="form-group">
								<input type="submit" name="loginbtn" value="Login" class="btn float-right login_btn">
							</div>
						</form>
					</div>
					<div class="card-footer text-center my-3">
						<?php 
							 if(isset($_GET['invailid_access'])) {
						?>
								<span class="bg-white text-danger"> Invailid contact_no or password!</span>
						<?php 
							}
						?>
						<div class="d-flex justify-content-center links">
							Don't have an account?<a href="?sign-up=1">Sign Up</a>
						</div>
						<div class="d-flex justify-content-center">
							<a href="#">Forgot your password?</a>
						</div>
					</div>
			<?php
				}
			?>


		</div>
	</div>
</div>
<script src="assest/js/jquery.js"></script>
<script src="assets/js/bootsrapmin.js"></script>

</body>
</html>



<?php 
	require_once("admin/inc/config.php");
	if(isset($_POST['sign_up_btn'])){
		$su_username = mysqli_real_escape_string($db, $_POST['su_username']);
		$su_contact_no = mysqli_real_escape_string($db, $_POST['su_contact_no']);
		$su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
		$retype_password = mysqli_real_escape_string($db, sha1($_POST['retype_password']));
		$user_role = "Voter" ;

		if($su_password == $retype_password)
		{
			// Query to insert 
			mysqli_query($db, "INSERT INTO user(username, contact_no, password, user_role) VALUES('".$su_username."', '".$su_contact_no."', '".$su_password."', '".$user_role."')") or die(mysqli_error($db));

		?>
			<script>location.assign("?sign-up=1&registered=1"); </script>
		<?php
		}else {
	?>
		<script>location.assign("?sign-up=1&invailid=1"); </script>
	<?php			
		}

	} else if(isset($_POST['loginbtn']))
		{
			$contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
			$password = mysqli_real_escape_string($db, sha1($_POST['password']));

			//fetch Query
			$fetchingData = mysqli_query($db, "SELECT * FROM user WHERE contact_no = '".$contact_no."'") or die(mysqli_error($db));

			if(mysqli_num_rows($fetchingData) > 0) 
			{
				$data = mysqli_fetch_assoc($fetchingData);

				if($contact_no == $data['contact_no'] AND $password == $data['password'])
				{
					session_start();
					$_SESSION['user_role'] =$data['user_role'];
					$_SESSION['username'] = $data['username'];
					$_SESSION['user_id'] = $data['id'];

					if($data['user_role']=="Admin")
					{
						$_SESSION['key'] = "AdminKey";
				?>
						<script> location.assign("admin/index.php?homePage=1"); </script>
				<?php

					}else {
						$_SESSION['key'] = "VotersKey";
				?>
							<script> location.assign("voters/index.php"); </script>
				<?php

					}

				}else {
		?>
					<script>location.assign("?invailid_access=1"); </script>
		<?php
				}

			} else {
		?>
				<script>location.assign("?sign-up=1&not_registered=1"); </script>
		<?php
			}

		}
?>