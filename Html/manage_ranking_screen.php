<?php
session_start();
error_reporting(0);
include("dbconnect.php");
  
    if (isset($_POST['add_uni_details'])) {
        $uni_name = $_POST["uni_name2"];
        $description = $_POST["description"];
        $location = $_POST["location"];
        $phone_no = $_POST["phone_no"];
        $library = $_POST["library"];
        $housing = $_POST["housing"];
        $sport_facilities = $_POST["sport_facilities"];
        $mosque = $_POST["mosque"];
        $health = $_POST["health"];
        $shuttle = $_POST["shuttle"];
        $postal = $_POST["postal"];
        $food_court = $_POST["food_court"];
        $details1 = $_POST["details1"];
        $details2 = $_POST["details2"];
        $details3 = $_POST["details3"];
        $file = $_FILES["image"]["tmp_name"]; 
        $maxsize    = 2097152;
        $acceptable = array(
            'application/pdf',
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );
      
      if(empty($library)){
          $library='No';
      }
      
      if(empty($housing)){
          $housing='No';
      }
      
      if(empty($sport_facilities)){
          $sport_facilities='No';
      }
      
      if(empty($mosque)){
          $mosque='No';
      }
      
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
      
      if(!isset($file)){
          echo "<script type='text/javascript'>alert('Please upload an image');window.location.assign('manage_ranking_screen.php');</script>'";
      }else{
            $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));    
            $image_size = getimagesize($_FILES['image']['tmp_name']);
            // if($image_size >$maxsize){
            //     echo "<script type='text/javascript'>alert('Please choose the image which is lees than 2md.');window.location.assign('manage_ranking_screen.php');</script>'";
            // }
            // else {
                $query = "INSERT INTO `tbl_university`(`image`,`university_name`, `description`, `location`, `phone_no`, `library`, `housing`, `sport`, `mosque`, `health`, `shuttle`, `postal`, `food_court`, `details_1`, `details_2`, `details_3`) VALUES('$image','$uni_name','$description','$location','$phone_no','$library','$housing','$sport_facilities','$mosque','$health','$shuttle','$postal','$food_court','$details1','$details2','$details3')";
                if(mysqli_query($conn, $query))
                {
                    echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_ranking_screen.php');</script>'";
                }else{
                    echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_ranking_screen.php');</script>'";
               }
            // }
      }
    }
    else if (isset($_POST['add_uni_ranking'])){
        $rank = $_POST["rank"];
        $uni_name = $_POST["uni_name1"];
        $state = $_POST["state"];
        $year = $_POST["year"];
        $favourite = "no";

        $query = "INSERT INTO `tbl_ranking`(`ranking_no`, `university_name`, `state`, `year`, `favourite`) VALUES('$rank','$uni_name','$state','$year','$favourite')";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_ranking_screen.php');</script>'";
        }else{
          echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_ranking_screen.php');</script>'";
        }
        
    }
    else if (isset($_POST['edit_uni_ranking'])){
      
        $uni_no = $_POST["uni_no"];
        $ranking_no = $_POST["ranking_no"];
        $uni_name = $_POST["uni_name"];
        $state = $_POST["state"];
        $year = $_POST["year"];
        
        $query = "UPDATE `tbl_ranking` SET ranking_no = '$ranking_no', university_name = '$uni_name', state = '$state', year = '$year' WHERE university_no = '$uni_no' ";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_ranking_screen.php');</script>'";
        }else{
          echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_ranking_screen.php');</script>'";
        }
    }
    else if (isset($_POST['delete_uni_ranking'])){
      
        $uni_no = $_POST["uni_no"];
        
        $query = "DELETE FROM `tbl_ranking` WHERE university_no = '$uni_no' ";
        if(mysqli_query($conn, $query))
        {
          echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_ranking_screen.php');</script>'";
        }else{
          echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_ranking_screen.php');</script>'";
        }
    }

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>manage ranking screen</title>
<link rel="stylesheet" href="../css/manage_ranking_screen2.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
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
			<li class="active"><i class="fa fa-list"></i>  Ranking</li>
			<li onClick="navigateManageScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-wrench"></i>  Manage</li>
			<li onClick="navigateAboutUsScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-info-circle"></i>  About Us</li>
			<li>More</li>
		</ul>
		
	</div>
	
	<div class="body" >
	    <?php
		    session_start();
            error_reporting(0);
            include("dbconnect.php");
            $year = $_POST['year'];
            
            if (isset($_POST['sort_uni_ranking_year'])){
        
                $sqlloadranking = "SELECT * FROM tbl_ranking WHERE year = $year";
                
            }else{
                $sqlloadranking = "SELECT * FROM tbl_ranking WHERE year = '2021'";
                $year='2021';
            }
        ?>
		<form method="post" >
		    <select name = "year" onchange = "favTutorial()" class="dropdown_btn_menu">
                <option value="2021" <?php if($year=='2021'){echo "selected='selected'";} ?>> 2021 </option>
                <option value="2020" <?php if($year=='2020'){echo "selected='selected'";} ?>> 2020 </option>
                <option value="2019" <?php if($year=='2019'){echo "selected='selected'";} ?>> 2019 </option>
            </select>
            <input type="submit" class="sort_btn" name='sort_uni_ranking_year' value="Sort">
		</form>
		<div>
			<button class="add_button_dialog1 add_button_position1" onClick="addRankingDialog();"><i class="fa fa-plus" ></i>  Ranking Record</button>
			<div id="addRankingModel" style="z-index: 2;">
				  <div class="modal-content1">
					<span class="close1" onClick="addRankingDialog();">&times;</span>
					<form method="post" class="add_form_style" >
						<label for="rank" class="add_label_style" style="margin-top: 20px;">Rank:</label><input type="number" name="rank" class="add_textfield_style" style="margin-top: 20px;" required><br>
						<label for="university_name" class="add_label_style">University Name:</label><input type="text" name="uni_name1" class="add_textfield_style" required><br>
						<label for="state" class="add_label_style">State:</label><input type="text"  name="state" class="add_textfield_style" required><br>
						<label for="year" class="add_label_style">Year:</label><input type="number" name="year" class="add_textfield_style" required><br>
						<input type="submit" class="add_button" name='add_uni_ranking' value="Add">
					</form>
				  </div>
			</div>
			<button class="add_button_dialog2 add_button_position2" onClick="addUniversityDialog();"><i class="fa fa-plus" ></i>  University Details</button>
				<div id="addUniversityModel" style="z-index: 2;">
				  <div class="modal-content2">
					<span class="close2" onClick="addUniversityDialog();">&times;</span>
					<form method="post" class="add_form_style" enctype="multipart/form-data">
						<label for="university_name" class="add_label_style">University Name:</label><input type="text" name="uni_name2" class="add_textfield_style" required><br>
						<label for="username" class="add_label_style">Description:</label><input type="text"  name="description" class="add_textfield_style" required><br>
						<label for="location" class="add_label_style">Location:</label><input type="text" name="location" class="add_textfield_style" required><br>
						<label for="phone_no" class="add_label_style">Phone No:</label><input type="text"  name="phone_no" class="add_textfield_style" pattern="[0-9]+([-\,][0-9]+)?" required><br>
						<label for="username" class="add_label_style float_text">Facility:</label>
						<div class="checkbox_div">
							<div class="small_checkbox_div">
								<input type="checkbox" name="library" class="checkbox_style" value="Yes" ><label for="username" class="">Library</label><br>
								<input type="checkbox" name="housing" class="checkbox_style" value="Yes" ><label for="username" class="">Housing</label><br>
								<input type="checkbox" name="sport_facilities" class="checkbox_style" value="Yes" ><label for="username" class="">Sport Facilities</label><br>
							</div>
							<div class="small_checkbox_div">
								<input type="checkbox" name="mosque" class="checkbox_style" value="Yes" ><label for="username" class="">Mosque</label><br>
								<input type="checkbox" name="health" class="checkbox_style" value="Yes" ><label for="username" class="">Health Service</label><br>
								<input type="checkbox" name="shuttle" class="checkbox_style" value="Yes" ><label for="username" class="">Shuttle Service</label><br>
							</div>
							<div class="small_checkbox_div">
								<input type="checkbox"  name="postal" class="checkbox_style" value="Yes" ><label for="username" class="">Postal Services</label><br>
								<input type="checkbox"  name="food_court" class="checkbox_style" value="Yes" ><label for="username" class="">Food Court and Catering Services</label><br>
							</div>
						</div>
						<label for="username" class="add_label_style">Details1:</label><input type="text"  name="details1" class="add_textfield_style" required><br>
						<label for="username" class="add_label_style">Details2:</label><input type="text"  name="details2" class="add_textfield_style" required><br>
						<label for="username" class="add_label_style">Details3:</label><input type="text"  name="details3" class="add_textfield_style" required><br>
						<input type="file" name="image" accept="image/*" required>
						<input type="submit" class="add_button" name='add_uni_details' value="Add"></input>
					</form>
				  </div>
			</div>
	</div>
		<table id="example">
			<thead>
				<tr>
					<th>Rank</th>
					<th>University</th>
					<th>State</th>
					<th>Year</th>
					<th>Action</th>
				</tr>
			</thead>
		<tbody>
		    
		    <?php
            $result = $conn->query($sqlloadranking);
		        if ($result->num_rows > 0){
		            while ($row = $result -> fetch_assoc()){
		                extract($row);
		                
		                ?>
		                <tr>
		                    <td><?php echo $ranking_no ?></td>
		                    <td style="cursor:pointer;"><?php echo $university_name ?></td>
		                    <td><?php echo $state ?></td>
		                    <td><?php echo $year ?></td>
		                    <td><button class='edit_button_dialog ' onclick="editDialog('<?php echo $university_no ?>','<?php echo $ranking_no ?>','<?php echo $university_name ?>','<?php echo $state ?>','<?php echo $year ?>')"><i class='fa fa-edit'></i></button><button class='delete_button_dialog' onClick="deleteDialog('<?php echo $university_no ?>')"><i class='fa fa-trash'></i></button></td>
		                </tr>
		            <?php
		            }
		            echo"</tbody>
                	</table>";
		        }else{
		            echo"0 result";
		        }
		    $conn->close();
		    ?>
		<div id="editUniversityModel" style="z-index: 3;">
				  <div class="modal-content3" >
					<span class="close3" onClick="editDialog();">&times;</span>
					<form method="post" class="add_form_style">
					    <input type="hidden" name="uni_no" id="uni_no1" class="edit_textfield_style" style="margin-top: 20px;">
						<label for="university_name" class="edit_label_style" style="margin-top: 20px;">Rank:</label><input type="number" name="ranking_no" id="ranking_no" class="edit_textfield_style" required><br>
						<label for="university_name" class="edit_label_style">University Name:</label><input type="text" name="uni_name" id="uni_name" class="add_textfield_style" required><br>
						<label for="username" class="edit_label_style">State:</label><input type="text"  name="state" id="state" class="edit_textfield_style" required><br>
						<label for="location" class="edit_label_style">Year:</label><input type="number" name="year" id="year" class="edit_textfield_style" required><br>
						<input type="submit" class="edit_button" name='edit_uni_ranking' value="Edit"></input>
					</form>
				  </div>
		</div>
	</div>
	<div id="deleteUniversityModel" style="z-index: 3; padding-top: 200px;">
		<div class="modal-content4">
			<span class="close4" onClick="deleteDialog();">&times;</span>
			<h1>Are you sure?</h1>
			<div>
			    <form method="post" class="add_form_style">
			        <input type="hidden" name="uni_no" id="uni_no2" class="edit_textfield_style">
			        <input type="submit" class="delete_button" name='delete_uni_ranking' value="Delete"></input>
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
	
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>	
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script type="text/javascript" class="init">

$(document).ready(function() {
    var events = $('#events');
    var table = $('#example').DataTable( {
        select: true,
        "pagingType": "full",
		oLanguage: {
			oPaginate: {
			    sFirst: '<span class="fa fa-angle-double-left pagination-left"></span>',
                sLast: '<span class="fa fa-angle-double-right pagination-right"></span>',
				sNext: '<span class="fa fa-angle-right pagination-right"></span>',
				sPrevious: '<span class="fa fa-angle-left pagination-left"></span>',
			}
    	},
    	select: {
            selector: "td:not(:first-child):not(:nth-child(3)):not(:nth-child(4)):not(:last-child)",
    	    style: 'single',
        }
    } );
    table
        .on( 'select', function ( e, dt, type, indexes ) {
            var rowData = table.row( indexes ).data()[1];
            // alert(rowData);
            window.location.assign("manage_university_details.php?data="+rowData);
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var rowData = table.row( indexes ).data().toArray();
            // alert(rowData);
            window.location.assign("manage_university_details.php?"+rowData);
        } );
} );

</script>
<script type="text/javascript">

function addRankingDialog(){
	const popup = document.getElementById('addRankingModel');
	popup.classList.toggle('active');
}
	
function addUniversityDialog(){
	const popup = document.getElementById('addUniversityModel');
	popup.classList.toggle('active');
}

function editDialog(uni_no,ranking_no,uni_name,state,year){
    // alert(year);
	const popup = document.getElementById('editUniversityModel');
	popup.classList.toggle('active');
	
	document.getElementById('uni_no1').value=uni_no;
	document.getElementById('ranking_no').value=ranking_no;
	document.getElementById('uni_name').value=uni_name;
	document.getElementById('state').value=state;
	document.getElementById('year').value=year;
	
}
	
function deleteDialog(uni_no){
    // alert(uni_no);
	const popup = document.getElementById('deleteUniversityModel');
	popup.classList.toggle('active');
	
	document.getElementById('uni_no2').value=uni_no;
}

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