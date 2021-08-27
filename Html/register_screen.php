<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/Exception.php';
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/PHPMailer.php';
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/SMTP.php';

    session_start();
    error_reporting(0);
    
    include("dbconnect.php");
  
    if (isset($_POST['register'])) {
        $Name = $_POST["Name"];
        $email = $_POST["Email"];
        $Password = $_POST["Password"];
        $CPassword = $_POST["CPassword"];
        $tick = $_POST["tick"];
        $status = "active";
      
        if($Password!=$CPassword){
          //this is javascript - message box and bring u to another page
            echo "<script type='text/javascript'>alert('Password Not match!');window.location.assign('register_screen.php');</script>'";
        }else{
            $query = "INSERT INTO `tbl_user`(`user_email`, `name`, `password`, `status`) VALUES('$email','$Name','$Password','$status')";
            if(mysqli_query($conn, $query))
            {
                // sendEmail($email,$otp);
                echo "<script type='text/javascript'>alert('Success!!!');window.location.assign('register_screen.php');</script>'";
                
            }else{
               echo "<script type='text/javascript'>alert('Failed!!!');window.location.assign('register_screen.php');</script>'";
            }
           
      }
      
    } 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register Screen</title>
<link rel="stylesheet" href="../css/register_screen.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	<div class="bg_color_div">
		<div class="wrap_div">
			<div class="center_card_div">
				<div class="center_card_left">
						
				</div>
				<div class="center_card_heading">
					<div style="font-size: 24px;">
						<i class="fa fa-mortar-board fa-5x"></i>
					</div>
					<h2 class="title_text1">Join Us</h2>
					<h2 class="subtitle_text1">Find Your Perfect University</h2>
				</div>
				<div class="center_card_body">
					<div class="center_card_body_part1">
						<div class="center_card_body_part1_1">
							<h2 class="center_card_body_text1">Register</h2>
						</div>
					</div>
					<div class="center_card_body_part2">
						<form method='post'>
							<input type="text" name='Name' class="textfield_style textfield_padding1" placeholder="Name" required>
							<input type="email" name='Email' class="textfield_style textfield_padding2" placeholder="Email" required>
							<input type="password" name='Password' class="textfield_style textfield_padding2" placeholder="Password" required>
							<input type="password" name='CPassword' class="textfield_style textfield_padding2" placeholder="Confirm Password" required>
							<input name='tick' type="checkbox" class="checkbox_style" value='tick' required>
							<p class="checkbox_text">I agree with all <a herf="termAndCondition.php" class="hyperlink_text">Term of Use </a> & <a herf="Privacy.php" class="hyperlink_text">Privacy </a></p>
						
					</div>
					<div class="center_card_body_part3">
						<button type="submit" name='register' class="register_button_style" >Register</button>
						<div class="login_div">
							<a  href="login_screen.php"  class="login_text">Login</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
