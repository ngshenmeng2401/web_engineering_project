<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>about_us</title>
<link rel="stylesheet" href="../css/about_us_screen.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
			<li class="active"><i class="fa fa-info-circle"></i>  About Us</li>
			<li>More</li>
		</ul>
		
	</div>
	<div class="body">
		<div class="body1">
			<div class="body1_1">
				<img src="../Images/logo UNI without bg.png" alt="logo" width="450" height="360">
			</div>
			<div class="body1_2">
				<h1>Welcome to UNI</h1>
				<h2>Finding a Suitable University,</h2>
				<h2>Creating a Brighter Future.</h2>
			</div>
		</div>
		<div class="body2">
			
		</div>
		<div class="body3">
			<div class="body3_1">
				<h1>ABOUT US</h1>
			</div>
			<div class="body3_2">
				<h3>Mission/ Vision:</h3>
				<h4>UNI upholds the spirit of serving the students who are about to go to university, and solve their doubts about entering the university.</h4>
			</div>
			<div class="body3_3">
				<div class="body3_3_1">
					<h3>Why UNI Established:</h3>
				</div>
				<div class="body3_3_2">
					<h4>1. Although all universities have their own websites for students to  find information on their own. However, there is no website that allows students to make a complete department classification so that students can more easily choose their ideal university.</h4>
				</div>
				<div class="body3_3_2">
					<h4>2. In order to let more students know more about the whole situation of the university. UNI hopes to use experience sharing to convey information to middle school students, so that middle school students can make a choice after understanding the situation of the university.</h4>
				</div>
				<div class="body3_3_3">
					<h4>3. Nowadays, young people's awareness of further education is low, they are not very interested in further education and do not know the importance of further education, so they voluntarily give up opportunities for further education. Therefore, UNI was established to instill the correct conception of young people about entering higher education.</h4>
				</div>
				<div class="body3_3_4">
					<h4>4. Make a channels make foreign students who interested in Malaysian universities more easier to understand the departments and universities provided by Malaysian universities.</h4>
				</div>
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
