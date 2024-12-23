<?php
 session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
if(isset($_POST['login']))
    {
        // Getting username/ email and password
        $uname=$_POST['username'];
        $password=md5($_POST['password']);
        // Fetch data from database on the basis of username/email and password
        $sql =mysqli_query($con,"SELECT AdminUserName,AdminEmailId,AdminPassword,userType FROM tbladmin WHERE (AdminUserName='$uname' && AdminPassword='$password')");
        $num=mysqli_fetch_array($sql);
        if($num>0)
        {
            $_SESSION['login']=$_POST['username'];
            $_SESSION['utype']=$num['userType'];
            echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
        }else{
            echo "<script>alert('Invalid Details');</script>";
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
<title>Seithipunal | Admin Login</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="">
<meta name="author" content="">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/color_skins.css">
</head>

<body class="theme-cyan">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="top">
                        <img src="assets/images/logo.png" alt="seithipunal-logo">
                    </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">Login</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" method="post">
                                <div class="form-group">
                                    <label for="signin" class="control-label sr-only">Email</label>
                                    <input type="text" class="form-control" name="username" value="" placeholder="Email" required="">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Password</label>
                                    <input type="password" class="form-control" name="password" value="" placeholder="Password" required="">
                                </div>
                                <!-- <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox">
                                        <span>Remember me</span>
                                    </label>								
                                </div> -->
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">LOGIN</button>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>
</html>
