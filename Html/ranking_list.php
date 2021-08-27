<?php
session_start();
error_reporting(0);
include("dbconnect.php");
$email = $_SESSION['email'];

if (isset($_POST['add_favourite'])){
    
    $uni_no = $_POST['university_no'];
     $sqlsearch = "SELECT * FROM `tbl_favourite` WHERE user_email = '$email' &&  `university_no`='$uni_no'";
    
    $result = $conn->query($sqlsearch);
    
    if ($result->num_rows > 0) {
       
        echo "<script type='text/javascript'>alert('This record already add into favourite list!');window.location.assign('ranking_list.php');</script>'";
          
    }else{
        $addFavourite = "INSERT INTO `tbl_favourite`(`university_no`, `user_email`) VALUES('$uni_no','$email')";
        if(mysqli_query($conn, $addFavourite)){
           echo  "<script type='text/javascript'>alert('Success!');window.location.assign('ranking_list.php');</script>'";
        }
        else{
            echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('ranking_list.php');</script>'";
        }
    }
    
    
}else if (isset($_POST['remove_favourite'])){
    
    $university_no = $_POST['university_no'];
    $favourite = "no";
    
    $updateFavouriteStatus = "UPDATE `tbl_ranking` SET favourite = '$favourite' WHERE university_no = '$university_no' ";

    if(mysqli_query($conn, $updateFavouriteStatus))
    {
        $deleteFavourite = "DELETE FROM `tbl_favourite` WHERE university_no = '$university_no' AND user_email = '$email'";
        if(mysqli_query($conn, $deleteFavourite)){
            echo "<script type='text/javascript'>alert('Success!');window.location.assign('ranking_list.php');</script>'";
        }

    }else{
        echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('ranking_list.php');</script>'";
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ranking_list</title>
<link rel="stylesheet" href="../css/ranking_list.css">
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
	<div class="body">
	    <?php
		    session_start();
            error_reporting(0);
            include("dbconnect.php");
            $year = $_POST['year'];
            $email = $_SESSION['email'];
            
            if (isset($_POST['sort_uni_ranking_year'])){
        
                // $sqlloadranking = "SELECT tbl_ranking.ranking_no, tbl_ranking.university_name, tbl_ranking.state, tbl_ranking.year, tbl_favourite.favourite FROM tbl_ranking LEFT JOIN tbl_favourite ON tbl_ranking.university_no = tbl_favourite.university_no WHERE year = '$year'";
                $sqlloadranking = "SELECT * FROM tbl_ranking WHERE year = '$year'";
                
            }else{
                // $sqlloadranking = "SELECT tbl_ranking.ranking_no, tbl_ranking.university_name, tbl_ranking.state, tbl_ranking.year, tbl_favourite.favourite FROM tbl_ranking LEFT JOIN tbl_favourite ON tbl_ranking.university_no = tbl_favourite.university_no WHERE year = '2021' ";
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
		                    <!--<td><?php echo $university_no ?></td>-->
		                    <td style="text-align: center">
                               
                                        <form method="post" >
        		                            <input type="hidden" class="sort_btn" name='university_no' value="<?php echo $university_no ?>">
                                            <button type="submit" class="favourite_button no_favourite_button_color" name='add_favourite'><i class="fa fa-heart" ></i></button>
                                		</form>
                               
		                    </td>
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

	
$(document).ready( function () {
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
            window.location.assign("university_details.php?data="+rowData);
        } )
        .on( 'deselect', function ( e, dt, type, indexes ) {
            var rowData = table.row( indexes ).data().toArray();
            window.location.assign("university_details.php?"+rowData);
        } );
} );
</script>
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
</html>
