<?php
    session_start();
    error_reporting(0);
    include("dbconnect.php");
    $data = $_GET["data"];

    if(isset($_POST['edit_uni_img'])){
        $file = $_FILES["image"]["tmp_name"];
    
        if(!isset($file)){
            echo "<script type='text/javascript'>alert('Please upload an image');</script>'";
        }else{
            $image= addslashes(file_get_contents($_FILES['image']['tmp_name'])); 
            $image_size = getimagesize($_FILES['image']['tmp_name']);
            // if($image_size >$maxsize){
            //     echo "<script type='text/javascript'>alert('Please choose the image which is lees than 2md.');window.location.assign('manage_ranking_screen.php');</script>'";
            // }
            // else {
                $query = "UPDATE `tbl_university` SET image = '$image' WHERE university_name = '$data' ";
                    if(mysqli_query($conn, $query))
                    {
                        echo "<script type='text/javascript'>alert('Success!');</script>'";
                    }else{
                        echo "<script type='text/javascript'>alert('Failed!!');</script>'";
                   }
            // }
        }
    }else if (isset($_POST['edit_uni_details1'])) {
        
        $description = $_POST["description"];
        $phone_no = $_POST["phone_no"];
        
        $query = "UPDATE `tbl_university` SET description = '$description', phone_no = '$phone_no' WHERE university_name = '$data'";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');</script>";
        }else{
          echo "<script type='text/javascript'>alert('Failed!');</script>";
        //   window.location.assign('manage_university_details.php?data='+$data);
        }
        
    }else if(isset($_POST['edit_uni_facility1'])){
        $library = $_POST['library'];
        $housing = $_POST['housing'];
        $sport = $_POST['sport'];
        $mosque = $_POST['mosque'];
        
        if(empty($library)){
          $library='No';
        }
        
        if(empty($housing)){
          $housing='No';
        }
        
        if(empty($sport)){
          $sport='No';
        }
        
        if(empty($mosque)){
          $mosque='No';
        }
        
        $query = "UPDATE `tbl_university` SET library = '$library', housing = '$housing', sport = '$sport', mosque = '$mosque' WHERE university_name = '$data'";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');</script>";
        }else{
          echo "<script type='text/javascript'>alert('Failed!');</script>";
        }
        
    }else if(isset($_POST['edit_uni_facility2'])){

        $health = $_POST['health'];
        $shuttle = $_POST['shuttle'];
        $postal = $_POST['postal'];
        $food_court = $_POST['food_court'];
        
        if(empty($health)){
          $health='No';
        }
        
        if(empty($shuttle)){
          $shuttle='No';
        }
        
        if(empty($postal)){
          $postal='No';
        }
        
        if(empty($food_court)){
          $food_court='No';
        }
        
        $query = "UPDATE `tbl_university` SET health = '$health', shuttle = '$shuttle', postal = '$postal', food_court = '$food_court' WHERE university_name = '$data'";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');</script>";
        }else{
          echo "<script type='text/javascript'>alert('Failed!');</script>";
        }
        
    }else if(isset($_POST['edit_uni_details3'])){
        $location = $_POST['location'];
        $file = $_FILES["location_image"]["tmp_name"];
        
        $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));    
        $image_size = getimagesize($_FILES['image']['tmp_name']);
        
        $query = "UPDATE `tbl_university` SET location = '$location' WHERE university_name = '$data'";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');</script>";
        }else{
          echo "<script type='text/javascript'>alert('Failed!');</script>";
        }
        
    }else if(isset($_POST['edit_uni_details4'])){
        $details1 = $_POST['details1'];
        $details2 = $_POST["details2"];
        $details3 = $_POST["details3"];
        
        $query = "UPDATE `tbl_university` SET details_1 = '$details1', details_2 = '$details2', details_3 = '$details3' WHERE university_name = '$data'";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');</script>";
        }else{
          echo "<script type='text/javascript'>alert('Failed!');</script>";
        }
    }

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>manage_university_details</title>
<link rel="stylesheet" href="../css/manage_university_details.css">
<script src="https://kit.fontawesome.com/42677d178e.js" crossorigin="anonymous"></script>
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
				<!--<img src="../Images/UUM.jpg" alt="image" height="330" width="630">-->
			</div>
			<div class="body_part1_2">
				<div class="body_part1_2_1">
					<!--<button class="edit_button_dialog" onClick="editDialog1('<?php echo $university_name ?>','<?php echo $description ?>','<?php echo $phone_no ?>')"><i class="fa fa-edit"></i></button>-->
				    <form method="post" enctype="multipart/form-data">
        				<input type="file" name="image" accept="image/*" style="margin:20px 0 0 25px" required>
        				<input type="submit" class="edit_button edit_img_btn_position" name="edit_uni_img" value="Edit">
        			</form>
				</div>
				<div class="body_part1_2_2">
				    <form method="post" class="add_form_style">
						<label for="university_name" class="edit_label_style" style="margin-top: 50px;">University Name:</label><input type="text" name="uni_name" class="edit_textfield_style" id="uni_name" value="<?php echo $university_name ?>" readonly><br>
						<label for="username" class="edit_label_style">Description:</label><input type="text"  name="description" class="edit_textfield_style" id="description" value="<?php echo $description ?>" required><br>
						<label for="phone_no" class="edit_label_style">Phone No:</label><input type="text" name="phone_no" class="edit_textfield_style" pattern="[0-9]+([-\,][0-9]+)?" value="<?php echo $phone_no ?>" id="phone_no" required><br>
						<input type="submit" class="edit_button" name="edit_uni_details1" value="Edit">
					</form>
     <!--               <h1><?php echo $university_name ?></h1>-->
					<!--<h2><?php echo $description ?></h2>-->
					<!--<h3><?php echo $phone_no ?></h3>-->
				</div>
			</div>
		</div>
		<div class="body_part2">
			<div class="body_part2_1">
				<div class="body_part2_1_1">
					<h1>Facilities:</h1>
					<!--<button class="edit_button_dialog" onClick="editDialog2('<?php echo $library ?>','<?php echo $housing ?>','<?php echo $sport ?>','<?php echo $mosque ?>','<?php echo $health ?>','<?php echo $shuttle ?>','<?php echo $postal ?>','<?php echo $food_court ?>')" style="margin-right: 30px;"><i class="fa fa-edit"></i></button>-->
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
            			    <form method="post" >
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="library" class="checkbox_style" value="Yes" id="library" <?php if($library=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $library ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="housing" class="checkbox_style" value="Yes" id="library" <?php if($housing=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $housing ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="sport" class="checkbox_style" value="Yes" id="library" <?php if($sport=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $sport ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="mosque" class="checkbox_style" value="Yes" id="library" <?php if($mosque=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $mosque ?></h3>-->
							</div>
							<input type="submit" class="edit_button" id="editbtn" name="edit_uni_facility1" value="Edit">
							</form>
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
            			    <form method="post" >
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="health" class="checkbox_style" value="Yes" id="library" <?php if($health=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $health ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="shuttle" class="checkbox_style" value="Yes" id="library" <?php if($shuttle=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $shuttle ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="postal" class="checkbox_style" value="Yes" id="library" <?php if($postal=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $postal ?></h3>-->
							</div>
							<div class="body_part2_1_2_1_2_2">
							    <input type="checkbox" name="food_court" class="checkbox_style" value="Yes" id="library" <?php if($food_court=='Yes'){echo "checked='checked'";} ?>>
								<!--<h3 ><?php echo $food_court ?></h3>-->
							</div>
							<input type="submit" class="edit_button" id="editbtn" name="edit_uni_facility2" value="Edit">
							</form>
						</div>
					</div>
					
				</div>
				
			</div>
			<div class="body_part2_2">
				<h2>Location:</h2>
				<!--<button class="edit_button_dialog" onClick="editDialog3('<?php echo $location ?>')" style=""><i class="fa fa-edit"></i></button>-->
				<img src="data:image/jpeg;charset=utf8;base64,<?php echo base64_encode($location_image); ?>" height="330" width="630"/>
                <form method="post" >
					<input type="text" name="location" class="edit_location_style" id="location" value="<?php echo $location ?>" required><br>
					<!--<input type="file" name="location_image" accept="image/*" required>-->
					<input type="submit" class="edit_button" name="edit_uni_details3" style="margin-top:42px" value="Edit">
				</form>
                <!--<h3><?php echo $location ?></h3>-->
			</div>
		</div>
		<div class="body_part3">
			<div class="body_part3_header">
				<h1 style="margin-bottom: 15px;">Details</h1>
				<!--<button class="edit_button_dialog" onClick="editDialog4('<?php echo $details_1 ?>','<?php echo $details_2 ?>','<?php echo $details_3 ?>')" style=""><i class="fa fa-edit"></i></button>-->
			</div>
		        <form method="post" >
                    <div class="body_part3_1">
                        <label class="edit_label_style" style="margin:0">Details1:</label><br>
                        <textarea name="details1" cols="45" rows="7" ><?php echo $details_1 ?></textarea>
                        <!--<label class="edit_label_style" >Details1:</label><input type="text" name="details1" class="edit_textfield_style" id="details1" value="<?php echo $details_1 ?>" required><br>-->
        				<!--<h2><?php echo $details_1 ?></h2>-->
        			</div>
        			<div class="body_part3_2">
        			    <label class="edit_label_style" style="margin:0">Details2:</label><br>
        			    <textarea name="details2" cols="45" rows="7" ><?php echo $details_2 ?></textarea>
        			    <!--<label class="edit_label_style" >Details2:</label><input type="text" name="details2" class="edit_textfield_style" id="details2" value="<?php echo $details_2 ?>" required><br>-->
        				<!--<h2><?php echo $details_2 ?></h2>-->
        			</div>
        			<div class="body_part3_3">
        			    <label class="edit_label_style" style="margin:0">Details3:</label><br>
        			    <textarea name="details3" cols="45" rows="7" ><?php echo $details_3 ?></textarea>
        			    <!--<label class="edit_label_style" >Details3:</label><input type="text" name="details3" class="edit_textfield_style" id="details3" value="<?php echo $details_3 ?>" required><br>-->
        				<!--<h2><?php echo $details_3 ?></h2>-->
        				<input type="submit" class="edit_button btn_4_position" name="edit_uni_details4" value="Edit">
        			</div>
        		</form>
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
</body>
</html>
