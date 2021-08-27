<?php
    session_start();
    error_reporting(0);
    include("dbconnect.php");
  
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/Exception.php';
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/PHPMailer.php';
    require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/SMTP.php';
  
    if (isset($_POST['login'])) {
        $email = $_POST["email"];
        $_SESSION["email"] = "$email";
        $password = $_POST["password"];
        $query = "SELECT * FROM `tbl_user` WHERE `user_email` = '$email' AND `password` = '$password' ";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result -> fetch_assoc()){
                extract($row);
                
                if($status=="block"){
                    echo "<script type='text/javascript'>alert('Account hass been block');window.location.assign('login_screen.php?');</script>'";
                }
            }
            
            if($_SESSION["email"]=="assignmentneed499@gmail.com"){
                echo "<script type='text/javascript'>alert('Admin mode');window.location.assign('dashboard_screen.php?');</script>'";
            }else{
                echo "<script type='text/javascript'>alert('Success');window.location.assign('dashboard_screen.php?');</script>'";
            }
        }else{
            echo "<script type='text/javascript'>alert('Fail!!!');window.location.assign('login_screen.php');</script>'";
        }
    }else if (isset($_POST['forget_password'])){
    
    $email = $_POST["email"];
    $newpassword = random_password(10);

    $sql = "SELECT * FROM tbl_user WHERE user_email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sqlupdate = "UPDATE tbl_user SET password = '$newpassword' WHERE user_email = '$email'";
            if ($conn->query($sqlupdate) === TRUE){
                    sendEmail($newpassword,$email);
                    echo "<script type='text/javascript'>alert('Please check your email');</script>'";
            }else{
                    echo "<script type='text/javascript'>alert('Failed!!');</script>'";
            }
        }
    
    }

function sendEmail($newpassword,$email){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;                           //Disable verbose debug output
    $mail->isSMTP();                                //Send using SMTP
    $mail->Host       = 'mail.javathree99.com';                         //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                       //Enable SMTP authentication
    $mail->Username   = 'uni123@javathree99.com';                         //SMTP username
    $mail->Password   = 'UUMISTHEBEST';                         //SMTP password
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;
    
    $from = "uni123@javathree99.com";
    $to = $email;
    $subject = "From UNI. Please reset your password";
    $message = "<p>Your account password has been reset. Please login again using the information below.</p><br><br><h3>Password:".$newpassword."</h3><br><br>";
    
    $mail->setFrom($from,"UNI");
    $mail->addAddress($to);                                             //Add a recipient
    
    //Content
    $mail->isHTML(true);                                                //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->send();
}

function random_password($length){
    //A list of characters that can be used in our random password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //Create blank string
    $password = '';
    //Get the index of the last character in our $characters string
    $characterListLength = mb_strlen($characters, '8bit') - 1;
    //Loop from 1 to the length that was specified
    foreach(range(1,$length) as $i){
        $password .=$characters[rand(0,$characterListLength)];
    }
    return $password;
}

?>
<html>
<head>
<meta charset="utf-8">
<title>Login_Screen</title>
<link rel="stylesheet" href="../css/login_screen.css">
</head>

<body>
	<div class="bg_color_div">
		<div class="wrap_div">
			<div class="center_card_div">
				<div class="center_card_left">
						
				</div>
				<div class="center_card_heading">
					<h2 class="title_text1">Welcome Back</h2>
					<h2 class="subtitle_text1">Sign in to continue access pages...</h2>
				</div>
				<div class="center_card_body">
					<div class="center_card_body_part1">
						<div class="center_card_body_part1_1">
							<h2 class="center_card_body_text1">Sign In</h2>
						</div>
					</div>
					<div class="center_card_body_part2">
						<form  method='post'>
							<input name='email' type="text" class="textfield_style textfield_padding1" placeholder="Email" required>
							<input name= 'password' type="password" class="textfield_style textfield_padding2" placeholder="Password" required>
							<input type="checkbox" class="checkbox_style" required>
							<h4 class="checkbox_text">Remember Me</h4>
						
					</div>
					<div class="center_card_body_part3">
						<button type='submit' name ='login' class="login_button_style" >Login</button>
						</form>
					     <div class="register_div">
							<a href="register_screen.php" class="register_text">Register New Account</a>
						</div>
						<div class="forgot_div">
							<a class="register_text" onClick="forgetPasswordDialog();">Forgot Password</a>
							<div id="forgetPasswordModel" style="z-index: 3; padding-top: 200px;">
                        		<div class="modal-content">
                        			<span class="close" onClick="forgetPasswordDialog();">&times;</span>
                        			<div>
                        			    <form method="post" class="add_form_style">
                        			        <input type="email" name="email" class="email_textfield_style" placeholder="Email" required>
                        			        <input type="submit" class="submit_button" name="forget_password" value="Submit">
                        				</form>
                        			</div>
                        		</div>
                    	    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function forgetPasswordDialog(){
	const popup = document.getElementById('forgetPasswordModel');
	popup.classList.toggle('active');
}
</script>
</html>
