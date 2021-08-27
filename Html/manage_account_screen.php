<?php
session_start();
error_reporting(0);
include("dbconnect.php");

if (isset($_POST['block_user'])){
    $email = $_POST["email"];
    $status = "block";
    
    $blockuser = "UPDATE `tbl_user` SET status = '$status' WHERE user_email = '$email' ";
    if(mysqli_query($conn, $blockuser))
    {
      echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_account_screen.php');</script>'";
    }else{
      echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_account_screen.php');</script>'";
    }
    
}
if (isset($_POST['unblock_user'])){
    $email = $_POST["email"];
    $status = "active";

    $unblockuser = "UPDATE `tbl_user` SET status = '$status' WHERE user_email = '$email' ";
    if(mysqli_query($conn, $unblockuser))
    {
      echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_account_screen.php');</script>'";
    }else{
      echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_account_screen.php');</script>'";
    }
}

if (isset($_POST['delete_user'])){
    $email = $_POST["email"];

    $unblockuser = "DELETE FROM tbl_user WHERE user_email = '$email' ";
    if(mysqli_query($conn, $unblockuser))
    {
      echo "<script type='text/javascript'>alert('Success!');window.location.assign('manage_account_screen.php');</script>'";
    }else{
      echo "<script type='text/javascript'>alert('Failed!!');window.location.assign('manage_account_screen.php');</script>'";
    }
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>manage_account_screen</title>
<link rel="stylesheet" href="../css/manage_account_screen.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
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
			<li class="active"><i class="fa fa-wrench"></i>  Manage</li>
			<li onClick="navigateAboutUsScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-info-circle"></i>  About Us</li>
			<li>More</li>
		</ul>
		
	</div>
	<div class="body">
	    <table id="example">
			<thead>
				<tr>
					<th>User Email</th>
					<th>Name</th>
					<th>Password</th>
					<th>Date Registration</th>
					<th>Phone No</th>
					<th>Gender</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			    
			    <?php
    		    session_start();
                error_reporting(0);
                include("dbconnect.php");
                $email = "assignmentneed499@gmail.com";
                
                $sqlloadranking = "SELECT * FROM tbl_user WHERE user_email != '$email'";
    		    
                $result = $conn->query($sqlloadranking);
    		        if ($result->num_rows > 0){
    		            while ($row = $result -> fetch_assoc()){
    		                extract($row);
    		                
    		                ?>
    		                <tr>
    		                    <td><?php echo $user_email ?></td>
    		                    <td><?php echo $name ?></td>
    		                    <td><?php echo $password ?></td>
    		                    <td><?php echo date('d/m/Y h:i A',strtotime($date_reg)) ?></td>
    		                    <td><?php echo $phone_no ?></td>
    		                    <td><?php echo $gender ?></td>
					            <td style="text-align:center;">
					                
					                <?php
					                    if($status == "active"){
					                        ?>
					                        <a class="block_animation">
					                            <button class="block_button_dialog" onclick="blockDialog('<?php echo $user_email ?>')"><i class="fa fa-lock"></i><i class="fa fa-unlock-alt"></i></button>
					                        </a>
					                        <?php
					                    }else if($status == "block"){
					                        ?>
					                        <a class="unblock_animation">
					                            <button class="unblock_button_dialog" onclick="unblockDialog('<?php echo $user_email ?>')"><i class="fa fa-lock"></i><i class="fa fa-unlock-alt"></i></button>
					                        </a>
					                        <?php
					                    }
					                ?>
					                <a class="delete_animation">
					                    <button class='delete_button_dialog' onClick="deleteDialog('<?php echo $user_email ?>')"><i class='fa fa-trash'></i><i class="fa fa-trash-o"></i></button>
					                </a>
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
                
			</tbody>
		</table>
	</div>
	<div id="blockUserModel" style="z-index: 3; padding-top: 200px;">
		<div class="block-modal-content">
			<span class="close" onClick="blockDialog();">&times;</span>
			<h1>Are you sure?</h1>
			<div>
			    <form method="post" class="add_form_style">
			        <input type="hidden" name="email" id="block_email" class="edit_textfield_style">
			        <input type="submit" class="block_button" name='block_user' value="Block"></input>
				</form>
			</div>
		</div>
	</div>
	<div></div>
	<div id="unblockUserModel" style="z-index: 3; padding-top: 200px;">
		<div class="unblock-modal-content">
			<span class="close" onClick="unblockDialog();">&times;</span>
			<h1>Are you sure?</h1>
			<div>
			    <form method="post" class="add_form_style">
			        <input type="hidden" name="email" id="unblock_email" class="edit_textfield_style">
			        <input type="submit" class="unblock_button" name='unblock_user' value="Unblock"></input>
				</form>
			</div>
		</div>
	</div>
	<div id="deleteUserModel" style="z-index: 3; padding-top: 200px;">
		<div class="delete-modal-content">
			<span class="close" onClick="deleteDialog();">&times;</span>
			<h1>Are you sure?</h1>
			<div>
			    <form method="post" class="add_form_style">
			        <input type="hidden" name="email" id="delete_email" class="edit_textfield_style">
			        <input type="submit" class="delete_button" name='delete_user' value="Delete"></input>
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

$(document).ready( function () {
    $('#example').DataTable({
		"pagingType": "full",
		oLanguage: {
			oPaginate: {
				sFirst: '<span class="fa fa-angle-double-left pagination-left"></span>',
                sLast: '<span class="fa fa-angle-double-right pagination-right"></span>',
				sNext: '<span class="fa fa-angle-right pagination-right"></span>',
				sPrevious: '<span class="fa fa-angle-left pagination-left"></span>',
			}
    	}
	});
} );
</script>
<script type='text/javascript'>

function blockDialog(email){
	const popup = document.getElementById('blockUserModel');
	popup.classList.toggle('active');
	
	document.getElementById('block_email').value=email;
}

function unblockDialog(email){
	const popup = document.getElementById('unblockUserModel');
	popup.classList.toggle('active');
	
	document.getElementById('unblock_email').value=email;
}

function deleteDialog(email){
	const popup = document.getElementById('deleteUserModel');
	popup.classList.toggle('active');
	
	document.getElementById('delete_email').value=email;
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
</body>
</html>