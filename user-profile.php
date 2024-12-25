<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
?>

<?php include('includes/topheader.php');?>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<!-- Left Sidebar End -->

<div id="main-content" class="profilepage_1">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> User Profile</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <ul class="nav nav-tabs">                                
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Settings">Settings</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
    
                            <div class="tab-pane active" id="Settings">

                                <!-- <div class="body">
                                    <h6>Profile Photo</h6>
                                    <div class="media">
                                        <div class="media-left m-r-15">
                                            <img src="../assets/images/user.png" class="user-photo media-object" alt="User">
                                        </div>
                                        <div class="media-body">
                                            <p>Upload your photo.
                                                <br> <em>Image should be at least 140px x 140px</em></p>
                                            <button type="button" class="btn btn-default-dark" id="btn-upload-photo">Upload Photo</button>
                                            <input type="file" id="filePhoto" class="sr-only">
                                        </div>
                                    </div>
                                </div> -->

                                <div class="body">
                                    <h6>Basic Information</h6>
                                    <div class="row clearfix">
                                        <?php
                                            session_start();

                                            // Get the logged-in user's name from the session (if available)
                                            $userName = isset($_SESSION['login']) ? $_SESSION['login'] : 'Guest'; // Default to 'Guest' if not logged in
                                            $userEmail = isset($_SESSION['AdminEmailId']) ? $_SESSION['AdminEmailId'] : 'Guest';
                                            $userNumber = isset($_SESSION['PhoneNumber']) ? $_SESSION['PhoneNumber'] : 'Guest';
                                            $userGender = isset($_SESSION['Gender']) ? $_SESSION['Gender'] : 'Guest';
                                            $userRole = isset($_SESSION['UserRole']) ? $_SESSION['UserRole'] : 'Guest';
                                            $userAddress = isset($_SESSION['Address']) ? $_SESSION['Address'] : 'Guest';

                                            //echo'<pre>'; print_r($userName);
                                        ?>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="form-group">
                                            	<div class="form-group">                                                
	                                                <input type="text" class="form-control" value="<?= htmlspecialchars($userName); ?>" placeholder="Username" readonly>
	                                            </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" value="<?= htmlspecialchars($userRole); ?>" placeholder="UserRole" readonly>
                                                </div>
	                                            <div class="form-group">
	                                                <input type="email" class="form-control" value="<?= htmlspecialchars($userEmail); ?>" placeholder="Email" readonly>
	                                            </div>
	                                            <div class="form-group">
	                                                <input type="text" class="form-control" value="<?= htmlspecialchars($userNumber); ?>" placeholder="Phone Number" readonly>
	                                            </div>
                                                <div>
                                                    <label class="fancy-radio">
                                                        <input name="gender2" value="male" <?= ($userGender === 'male') ? 'checked' : ''; ?> type="radio" readonly onclick="return false;">
                                                        <span><i></i>Male</span>
                                                    </label>
                                                    <label class="fancy-radio">
                                                        <input name="gender2" value="female" <?= ($userGender === 'female') ? 'checked' : ''; ?> type="radio" readonly onclick="return false;">
                                                        <span><i></i>Female</span>
                                                    </label>
                                                    <label class="fancy-radio">
				                                        <input name="gender2" value="others" <?= ($userGender === 'others') ? 'checked' : ''; ?> type="radio" readonly onclick="return false;">
				                                        <span><i></i>Others</span>
				                                    </label>
                                                </div>
                                                <div class="form-group">                                                
	                                                <input type="text" class="form-control" value="<?= htmlspecialchars($userAddress); ?>" placeholder="Address Line" readonly>
	                                            </div>
	                                            <!-- <div class="form-group">
	                                                <input type="text" class="form-control" placeholder="Address Line 2">
	                                            </div>
	                                            <div class="form-group">
	                                                <input type="text" class="form-control" placeholder="City">
	                                            </div>
	                                            <div class="form-group">
	                                                <input type="text" class="form-control" placeholder="State/Province">
	                                            </div> -->
                                            </div> 
                                        </div>

                                        <div class="col-lg-6 col-md-12">
                                            <h6>Change Password</h6>
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="Current Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="New Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="Confirm New Password">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('includes/footer.php');?>

<?php } ?>