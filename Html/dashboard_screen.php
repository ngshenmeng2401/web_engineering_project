<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>dashboard_screen</title>
<link rel="stylesheet" href="../css/dashboard_screen.css">
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
            }else{
                
            ?>
                <button onClick="navigateLoginScreen()" class="login_button_style login_button_position" id="">LOGIN</button>
                <button onClick="navigateRegisterScreen()" class="sign_in_button_style sign_in_button_position" id="">SIGN UP</button>
            <?php
            }
		?>
		<ul class="nav">
			<li class="active"><i class="fa fa-home"></i>  Home</li>
			<li onClick="navigateRankingScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-list"></i>  Ranking</li>
			<li onClick="navigateManageScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-wrench"></i>  Manage</li>
			<li onClick="navigateAboutUsScreen('<?php echo $_SESSION['email'] ?>')"><i class="fa fa-info-circle"></i>  About Us</li>
			<li>More</li>
		</ul>
		
	</div>
	<div class="body">
		<div class="body_part1">
			<div class="body_part1_1">
				<div id="barchart_values"></div>
			</div>
			<div class="body_part1_2">
				<h2>Top 5 Government University in Malaysia 2021</h2>
				<h3>First rank is University Malaya which the overall score is 93. Next, the second rank is University Kebangsaan Malaysia and the third rank is University Putra Malaysia which the overall score are 87 and 85 respectively. Besides that, University Sains  Malaysia ranked fourth and Univerisity Teknology Malaysia ranked fifth which overall score are 83 and 80 respectively.</h3>
				<button onClick="navigateRankingScreen('<?php echo $_SESSION['email'] ?>')">View Full List</button>
			</div>
		</div>
		<div class="body_divider"></div>
		<div class="body_part2">
			<div class="body_part2_1">
				<h2>Number of Government University Student and Private College Student</h2>
				<h3>The number of government university students is 500000 in 2021.On the other hand, the numebr of private college students is 600000 in 2021.</h3>
			</div>
			<div class="body_part2_2">
				<div id="piechart" ></div>
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
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {

		var data = google.visualization.arrayToDataTable([
		  ['Task', 'Number of Student'],
		  ['Government University',     500000],
		  ['Private University',      600000],

		]);

		var options = {
			title: 'Number of Government University Students and Private College Students',
			titleTextStyle:{
				color: 'black',
				fontName: "Arial",
				fontSize: 14,
				
			},
			backgroundColor : 'transparent',
			'width':630,
			'height':300,
			chartArea: {
				height: "80%",
				width: "80%"
			},
			animation: {
				duration: 1000,
				easing: 'in',
				startup: true,
			},
			legend:{
				alignment:"center",
				position:"right",
			},
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		chart.draw(data, options);

		var percent = 0;

		var handler = setInterval(function(){
				// values increment
				percent += 1;
				// apply new values
				data.setValue(0, 1, percent);
				data.setValue(1, 1, 100 - percent);
				// update the pie
				chart.draw(data, options);
				// check if we have reached the desired value
				if (percent > 45)
					// stop the loop
					clearInterval(handler);
			}, 30);
	}
</script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
		var data = google.visualization.arrayToDataTable([
			["Element", "Score", { role: "style" } ],
			["University Malaya", 93, "#FFC000"],
			["University Kebangsaan Malaysia", 87, "#F9DDA5"],
			["University Putra Malaysia", 85, "#FFC000"],
			["University Sains Malaysia", 83, "#F9DDA5"],
			["University Teknologi Malaysia", 80, "#FFC000"],
		]);

		var options = {
			
			title: "Top 5 Government University in Malaysia",
			titleTextStyle:{
				color: 'black',
				fontName: "Arial",
				fontSize: 20,
			},
			backgroundColor : 'transparent',
			'width':630,
			'height':280,
			chartArea: {
				height: "80%",
				width: "80%"
			},
			legend: { position: "none" },
			hAxis: {
				textPosition: 'none', 
				baselineColor: 'none',
				gridlineColor: 'none',
			},
			vAxis: { 
				textPosition: 'in',
				baselineColor: 'none',
				gridlineColor: 'none',
			},
			animation:{
				duration:'1000',
				startup:true,
				easing:'inAndOut',
			},
			timeline: { 
				showBarLabels: false 
			},
			bar: {
				groupWidth: '80%'
			},
			series: { 1: { pointSize: 2, type: 'line' } },
		};
			var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
			chart.draw(data, options);
  }
</script>
<script type='text/javascript'>
function navigateLoginScreen(){
    
    window.location.assign("login_screen.php?");
}

function navigateRegisterScreen(){
    window.location.assign("register_screen.php?");
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
