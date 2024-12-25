<?php
    session_start();
    error_reporting(0);
    include('includes/config.php');

    if(isset($_POST['submit']))
    {
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=md5($_POST['newpassword']);
        $query=mysqli_query($con,"select id from tbladmin where  AdminEmailId='$email' and AdminUserName='$username' ");
        
        $ret=mysqli_num_rows($query);
        if($ret>0){

        $query1=mysqli_query($con,"update tbladmin set AdminPassword='$password'  where  AdminEmailId='$email' && AdminUserName='$username' ");

        if($query1)
        {
            echo "<script>alert('Password successfully changed');</script>";
            echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        }
    }
    else{
    
      echo "<script>alert('Invalid Details. Please try again.');</script>";
    }
  }

  /*Logo Show Starts*/
        $pagetype = 'home';
        $query = mysqli_query($con, "SELECT PageImage FROM tblpages WHERE PageName='$pagetype'");
        $row = mysqli_fetch_array($query);
        $image = $row['PageImage'];
    /*Logo Show Ends*/

?>

<!doctype html>
<html lang="en">

<head>
<title>Seithipunal | Forgot Password</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
<meta name="author" content="WrapTheme, design by: ThemeMakker.com">

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
		<div class="auth-container">
            <!-- Left Side (Login Form and Logo) -->
            <div class="auth-left">
				<div class="auth-box">
                    <div class="top">
                        <img src="postimages/<?php echo htmlentities($image); ?>" alt="Lucid">
                    </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">Recover my password</p>
                        </div>
                        <div class="body">
                            <p>Please enter below to for resetting password.</p>
                            <form class="form-auth-small" method="post">
                                <div class="form-group">                                    
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username(Login)">
                                </div>
                                <div class="form-group">                                    
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                </div>
                                <div class="form-group">                                    
                                    <input type="password" class="form-control" name="newpassword" id="userpassword" placeholder="New Password">
                                </div>
                                <div class="form-group">                                    
                                    <input type="password" class="form-control" name="confirmpassword" id="userpassword" placeholder="Confirm Password">
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">RESET PASSWORD</button>
                                <div class="bottom">
                                    <span class="helper-text">Know your password? <a href="index.php">Login</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>

            <!-- Right Side (Background Image) -->
            <div class="auth-right"></div>

		</div>
	</div>
	<!-- END WRAPPER -->
</body>
</html>

<script type="text/javascript">
    document.querySelector('form').onsubmit = function() {
        var newPassword = document.getElementById('userpassword').value;
        var confirmPassword = document.getElementsByName('confirmpassword')[0].value;
        
        if (newPassword !== confirmPassword) {
            alert('New Password and Confirm Password fields do not match.');
            return false;
        }
        return true;
    }
</script>

