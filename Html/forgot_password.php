<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/Exception.php';
require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/PHPMailer.php';
require '/home8/javathre/public_html/web_project/Code/HTML/PHPMailer/SMTP.php';

include_once("dbconnect.php");

if (isset($_POST['forget_password'])){
    
    $email = $_POST['email'];
    $newpassword = random_password(10);
    $passha = sha1($newpassword);
    echo $email;
    
    $sql = "SELECT * FROM tbl_user WHERE user_email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $sqlupdate = "UPDATE tbl_user SET password = '$passha' WHERE user_email = '$email'";
            if ($conn->query($sqlupdate) === TRUE){
                    sendEmail($newpassword,$email);
                    echo 'success';
            }else{
                    echo 'failed';
            }
        }else{
            echo "failed";
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
    $message = "<p>Your account password has been reset. Please login again using the information below.</p><br><br><h3>Password:".$newpassword."</h3><br><br>
    Click Here to reactivate your account</a>";
    
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