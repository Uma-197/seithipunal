<!doctype html>
<html lang="en">

<head>
    <title>Seithipunal</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/vendor/sweetalert/sweetalert.css"/>

    <!-- <link rel="stylesheet" href="assets/vendor/summernote/dist/summernote.css"/> -->
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css">
    <link rel="stylesheet" href="assets/vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="assets/vendor/toastr/toastr.min.css">

    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">
</head>
<body class="theme-cyan">

<!-- Page Loader -->
<!-- <div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="assets/images/logo-icon.svg" width="48" height="48" alt="seithipunal-logo"></div>
        <p>Please wait...</p>        
    </div>
</div> -->
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-btn">
                <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
            </div>

            <div class="navbar-brand">
                <a href="#"><img src="assets/images/logo.png" alt="seithipunal-logo" class="img-responsive logo"></a>                
            </div>
            
            <div class="navbar-right">
                <!-- <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>  --> 

                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"><b>Today Trending News : </b><b>For any Info Contact </b>seithipunaltamil@gmail.com</marquee>

                <div class="user-account">
                    <img src="assets/images/user.jpg" class="rounded-circle user-photo" alt="User Profile Picture">
                    <div class="dropdown">
                        <?php
                        session_start();

                        // Get the logged-in user's name from the session (if available)
                        $userName = isset($_SESSION['login']) ? $_SESSION['login'] : 'Guest'; // Default to 'Guest' if not logged in
                        ?>
                        <span>Welcome,</span>
                        <a href="javascript:void(0);" class="user-name" data-toggle="dropdown"><strong><?php echo htmlentities($userName); ?></strong></a>
                    </div>             

                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="logout.php" class="icon-menu"><i class="icon-power"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>