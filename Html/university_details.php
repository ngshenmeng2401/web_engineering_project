<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>university_details</title>
<link rel="stylesheet" href="../css/university_details.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/42677d178e.js" crossorigin="anonymous"></script>
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
                                <img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($profile_img); ?>" class="profile_image" onClick="navigateProfileScreen('<?php echo $_SESSION['email'] ?>')">
                               <?php
                            }else{
                                ?>
                                <img src="../Images/profile.png" alt="img" class="profile_image" onClick="navigateProfileScreen('<?php echo $_SESSION['email'] ?>')">
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
			<div class="body_part1_1 float_left">
			    <?php
			        session_start();
                    error_reporting(0);
                    include("dbconnect.php");

                    $data = $_GET["data"];
                    
                    $sqlloaduni = "SELECT * FROM tbl_university WHERE university_name = '$data'";
                    $result = $conn->query($sqlloaduni);
                    if ($result->num_rows > 0){
                        while ($row = $result -> fetch_assoc()){
                            extract($row);
                            ?>
                <img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($image); ?>" height="330" width="630"/>
			</div>
			<div class="body_part1_2">
				<div class="body_part1_2_1">
				</div>
				<div class="body_part1_2_2">
				    <h1><?php echo $university_name ?></h1>
					<h2><?php echo $description ?></h2>
					<h3><?php echo $phone_no ?></h3>
					
				</div>
			</div>
		</div>
		<div class="body_part2">
			<div class="body_part2_1">
				<div class="body_part2_1_1">
					<h1>Facilities:</h1>					
				</div>
				<div class="body_part2_1_2">
					<div class="body_part2_1_2_1">
						<div class="body_part2_1_2_1_1">
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-building"></i>
								<h3 class="facility_name_style">Library</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-home"></i>
								<h3 class="facility_name_style">Housing</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-basketball-ball"></i>
								<i class="fas fa-biking"></i>
								<i class="fas fa-swimming-pool"></i>
								<h3 class="facility_name_style">Sport Facilities</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-mosque"></i>
								<i class="fas fa-mosque"></i>
								<h3 class="facility_name_style">Mosque</h3>
							</div>
						</div>
						<div class="body_part2_1_2_1_2">
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $library ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $housing ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $sport ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $food_court ?></h3>
							</div>
						</div>
					</div>
					<div class="body_part2_divider"></div>
					<div class="body_part2_1_2_1">
						<div class="body_part2_1_2_1_1">
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-clinic-medical"></i>
								<i class="fas fa-hospital"></i>
								<i class="fas fa-medkit"></i>
								<h3 class="facility_name_style">Health Services</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fa fa-bus"></i>
								<i class="fas fa-bus-alt"></i>
								<h3 class="facility_name_style">Shuttle  Services</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fas fa-shipping-fast"></i>
								<h3 class="facility_name_style">Postal  Services</h3>
							</div>
							<div class="body_part2_1_2_1_2_1">
								<i class="fa fa-coffee"></i>
								<i class="fas fa-pizza-slice"></i>
								<i class="fas fa-hamburger"></i>
								<h3 class="facility_name_style">Food Court and Catering  Services</h3>
							</div>
						</div>
						<div class="body_part2_1_2_1_2">
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $health ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $shuttle ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $postal ?></h3>
							</div>
							<div class="body_part2_1_2_1_2_2">
								<h3 ><?php echo $mosque ?></h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="body_part2_2">
				<h2>Location:</h2>
				<img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($location_image); ?>" height="330" width="630"/>
				<h3><?php echo $location ?></h3>
				<!--<img src="../Images/map.jpg" alt="image" height="330" width="630">-->
				<!--<h3>International Islamic University Malaysia Jalan Gombak 53100 Kuala Lumpur Selangor Malaysia.</h3>-->
			</div>
		</div>
		<div class="body_part3">
			<div class="body_part3_header">
				<h1>Details</h1>
			</div>
			<div class="body_part3_1">
			    <h2><?php echo $details_1 ?></h2>
			</div>
			<div class="body_part3_2">
			    <h2><?php echo $details_2 ?></h2>
			</div>
			<div class="body_part3_3">
			    <h2><?php echo $details_3 ?></h2>
			</div>
			<?php
                    }
                }else{
		            echo"0 result";
		        }
		    $conn->close();
            ?>
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
<script type='text/javascript'>

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

function navigateProfileScreen(email){
    if(email=="assignmentneed499@gmail.com"){
        window.location.assign("admin_profile_screen.php?");
    }
    else{
        window.location.assign("profile_screen.php?");
    }
}

function logOut(){
    window.location.assign("logout.php?");
    window.location.assign("login_screen.php?");
}
</script>
</html>
