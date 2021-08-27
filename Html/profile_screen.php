<?php
session_start();
error_reporting(0);
include("dbconnect.php");

    if(isset($_POST['edit_user_profile'])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone_no = $_POST["phone_no"];
        $gender = $_POST["gender"];

        $query = "UPDATE `tbl_user` SET name = '$name', phone_no = '$phone_no', gender = '$gender' WHERE user_email = '$email' ";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');window.location.assign('profile_screen.php');</script>'";
        }else{
          echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('profile_screen.php');</script>'";
        }
        
    }else if(isset($_POST['edit_user_password'])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        
        if($password!=$confirm_password){
            
            echo "<script type='text/javascript'>alert('Both Password Not Same!!!');</script>'";
            
        }else{
            $query = "UPDATE `tbl_user` SET password = '$password' WHERE user_email = '$email' ";
            if(mysqli_query($conn, $query))
            {
              echo "<script type='text/javascript'>alert('Success!');window.location.assign('profile_screen.php');</script>'";
            }else{
              echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('profile_screen.php');</script>'";
            }
        }
    }else if(isset($_POST['edit_profile_img'])){
        $email = $_POST["email"];
        $file = $_FILES["image"]["tmp_name"];
    
        if(!isset($file)){
            echo "<script type='text/javascript'>alert('Please upload an image');window.location.assign('profile_screen.php');</script>'";
        }else{
            $image= addslashes(file_get_contents($_FILES['image']['tmp_name'])); 
            $image_size = getimagesize($_FILES['image']['tmp_name']);
            // if($image_size >$maxsize){
            //     echo "<script type='text/javascript'>alert('Please choose the image which is lees than 2md.');window.location.assign('manage_ranking_screen.php');</script>'";
            // }
            // else {
                $query = "UPDATE `tbl_user` SET profile_img = '$image' WHERE user_email = '$email' ";
                    if(mysqli_query($conn, $query))
                    {
                        echo "<script type='text/javascript'>alert('Success!');window.location.assign('profile_screen.php');</script>'";
                    }else{
                        echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('profile_screen.php');</script>'";
                   }
            // }
        }
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>profile_screen</title>
<link rel="stylesheet" href="../css/profile_screen.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
	<div class="header">
		<img src="../Images/logo UNI without bg.png" alt="logo" class="logo_image">
		<?php
		    session_start();
            error_reporting(0);
            include("dbconnect.php");
            // echo $_SESSION["email"];
            $email = $_SESSION['email'];
            if (isset($_SESSION["email"])){
                
                $sqlloaduser = "SELECT * FROM tbl_user WHERE user_email = '$email'";
                    $result = $conn->query($sqlloaduser);
                    if ($result->num_rows > 0){
                        while ($row = $result -> fetch_assoc()){
                            extract($row);
                            
                            if(isset($profile_img)){
                               ?>
                                <img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($profile_img); ?>" class="profile_image" onClick="navigateManageScreen('<?php echo $_SESSION['email'] ?>')">
                               <?php
                            }else{
                                ?>
                                <img src="../Images/profile.png" alt="img" class="profile_image" onClick="navigateManageScreen('<?php echo $_SESSION['email'] ?>')">
                                <?php
                            }
                        }
                    }
                ?>
		        <button onClick="logOut()" class="sign_in_button_style sign_in_button_position" id="">LOGOUT</button>
            <?php
            }
		?>
		<ul class="nav">
			<li onClick="navigateDashboardScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-home"></i>  Home</li>
			<li onClick="navigateRankingScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-list"></i>  Ranking</li>
			<li onClick="navigateManageScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-wrench"></i>  Manage</li>
			<li onClick="navigateAboutUsScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-info-circle"></i>  About Us</li>
			<li>More</li>
		</ul>
		
	</div>
	<div class="body">
		<div class="body_part1">
			<div class="body_part1_1">
				<h2>MY PROFILE</h2>
			</div>
			<div class="body_part1_2">
				<div class="body_part1_2_1">
					<h3>Manage Your Account</h3>
				</div>
				<div class="body_part1_2_2">
					<div class="body_part1_2_2_1">
						<h3 for="name" style="margin-top: 10px">Name</h3>
						<h3 for="email">Email</h3>
						<h3 for="phone_no">Phone No</h3>
						<h3 for="gender">Gender</h3>
					</div>
					<div class="body_part1_2_2_2">
					    <?php
                        session_start();
                        error_reporting(0);
                        include("dbconnect.php");
                        // echo $_SESSION["email"];
                        $email = $_SESSION['email'];
                        // echo $email;
                        $sqlloaduser = "SELECT * FROM tbl_user WHERE user_email = '$email'";
                        $result = $conn->query($sqlloaduser);
                        if ($result->num_rows > 0){
                            while ($row = $result -> fetch_assoc()){
                                extract($row);
                        ?>
						<form method="post">
							<input type="text" name = "name" value="<?php echo $name ?>" style="margin-top: 10px" required>
							<input type="email" name = "email" value="<?php echo $email ?>" readonly>
							<input type="text" name = "phone_no" value="<?php echo $phone_no ?>" required>
							<select name = "gender" onchange = "favTutorial()" class="dropdown_btn_menu" required>
								<option > Gender </option>
								<option value="Male" <?php if($gender=='Male'){echo "selected='selected'";} ?>> Male </option>
								<option value="Female" <?php if($gender=='Female'){echo "selected='selected'";} ?>> Female </option>
							</select>
						<?php
                                }
                            }
                        ?>
					</div>
				</div>
				<div class="body_part1_2_3">
						<input type="submit" name="edit_user_profile" value="SAVE">
					</form>
				</div>
				<div class="body_part1_2_4">
					<div class="body_part1_2_4_1">
						<h3 for="confirm_password">Password</h3>
						<h3 for="confirm_password">Confirm Password</h3>
					</div>
					<div class="body_part1_2_4_2">
						<form method="post">
						    <input type="hidden" name = "email" value="<?php echo $email ?>" >
							<input type="password" name = "password" required>
							<input type="password" name = "confirm_password" required>
					</div>
				</div>
			</div>
			<div class="body_part1_3">
					<input type="submit" name="edit_user_password" value="SAVE">
				</form>
			</div>
		</div>
		<div class="divider"></div>
		<div class="body_part2">
			<div class="body_part2_1"></div>
			<div class="body_part2_2">
				<div class="body_part2_2_1">
					<?php
                        session_start();
                        error_reporting(0);
                        include("dbconnect.php");
                        // echo $_SESSION["email"];
                        $email = $_SESSION['email'];
                        // echo $email;
                        $sqlloaduser = "SELECT * FROM tbl_user WHERE user_email = '$email'";
                        $result = $conn->query($sqlloaduser);
                        if ($result->num_rows > 0){
                            while ($row = $result -> fetch_assoc()){
                                extract($row);
                                if(empty($profile_img)){
                                    
                                    ?>
                                    <img src="../Images/profile.png" alt="profile picture" width="250" height="250">
                                    <?php
                                }else{
                                    ?>
                                    <img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($profile_img); ?>" height="250" width="250"/>
                                    <?php
                                }
                            }
                        }
                    ?>
				</div>
				<div class="body_part2_2_2">
					<h3>Select Image:</h3>
					<form method="post" enctype="multipart/form-data">
					    <input type="hidden" name = "email" value="<?php echo $email ?>" >
						<input type="file" name="image" accept="image/*" required>
				</div>
			</div>
			<div class="body_part2_3">
					<input type="submit" name="edit_profile_img" value="SAVE">
				</form>
			</div>
		</div>
	</div>
	<div class="footer">
		<p class="footerwordleft">© 2020 by Uni. Proudly created with Adobe Dreamweaver</p>
		<a href="#" class="fa fa-facebook"></a>
		<a href="#" class="fa fa-instagram"></a>
		<a href="#" class="fa fa-twitter"></a>
		<a href="#" class="fa fa-youtube"></a>
	</div>
</body>
<script>
function navigateDashboardScreen(email){
    // alert(email);
    if(email==""){
        alert("Please log in an account to get further information.");
        
    }else if(email=="assignmentneed499@gmail.com"){
        
        window.location.assign("dashboard_screen.php?");
    }
    else{
        window.location.assign("dashboard_screen.php?");
    }
}

function navigateRankingScreen(email){
    // alert(email);
    if(email==""){
        alert("Please log in an account to get further information.");
        
    }else if(email=="assignmentneed499@gmail.com"){
        
        window.location.assign("manage_ranking_screen.php?");
    }
    else{
        window.location.assign("ranking_list.php?");
    }
}

function navigateManageScreen(email){
    if(email==""){
        alert("Please log in an account to get further information.");
        
    }else if(email=="assignmentneed499@gmail.com"){
        window.location.assign("manage_account_screen.php?");
    }
    else{
        window.location.assign("favourite_list.php?");
    }
}

function navigateAboutUsScreen(email){
    if(email==""){
        alert("Please log in an account to get further information.");
        
    }else if(email=="assignmentneed499@gmail.com"){
        window.location.assign("about_us_screen.php?");
    }
    else{
        window.location.assign("about_us_screen.php?");
    }
    
}

function logOut(){
    window.location.assign("logout.php?");
    window.location.assign("login_screen.php?");
}
</script>
</html>
