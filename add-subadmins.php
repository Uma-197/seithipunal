<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
   
            // Code for Add New Sub Admi
            if(isset($_POST['submit'])){
                $username=$_POST['sadminusername'];
                $userrole=$_POST['userrole'];
                $email=$_POST['emailid'];
                $password=md5($_POST['pwd']);
                $phonenumber = $_POST['phonenumber'];
                $gender = $_POST['gender2']; // Get selected gender value
                $address = $_POST['address'];
      
                // Determine the usertype based on userrole
                if ($userrole === 'admin') {
                    $usertype = '0';
                }  elseif ($userrole === 'staff') {
                    $usertype = '2';
                }  else {
                // Optional: Handle other roles or set a default value
                $usertype = '1'; // Example default value
            }

            // Check if the username or email already exists
            $checkQuery = mysqli_query($con, "SELECT * FROM tbladmin WHERE AdminUserName='$username' OR AdminEmailId='$email'");
            if (mysqli_num_rows($checkQuery) > 0) {
                $error = "Username or Email already exists.";
            } else {

                $query=mysqli_query($con,"insert into tbladmin(AdminUserName,UserRole,AdminEmailId,AdminPassword,userType,PhoneNumber,Gender,Address,Is_Active ) values('$username','$userrole','$email','$password','$usertype','$phonenumber','$gender','$address',1)");
                if($query){
                    $msg="User Created ";
                } else {
                    $error="Something went wrong . Please try again."; 
                }
            }
        }
?> 


<?php include('includes/topheader.php');?>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<!-- Left Sidebar End -->

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add User</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">User</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <!---Success Message--->  
                    <?php if($msg){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        <strong>Well done!</strong> <?php echo htmlentities($msg);?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } ?>
                    <!---Error Message--->
                    <?php if($error){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                        <strong>Oh snap!</strong> <?php echo htmlentities($error);?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="addsuadmin" method="post">
                                <div class="form-group">
                                    <label for="exampleInputusername">Username (Used For Login)</label>
                                    <input type="text" placeholder="Enter Username"  name="sadminusername" id="sadminusername" class="form-control"  required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Email Id</label>
                                    <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Enter Email" required/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Enter Phone Number" required/>
                                </div>

                                <div>
                                    <label class="control-label">Gender</label><br>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="male" type="radio">
                                        <span><i></i>Male</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="female" type="radio">
                                        <span><i></i>Female</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="other" type="radio">
                                        <span><i></i>Others</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="userrole">User Role</label>
                                    <select class="form-control" name="userrole" id="userrole" required>
                                       <option value="">Select Role </option>
                                       <option value="admin">Admin</option>
                                       <option value="staff">Staff</option>
                                    </select>
                                 </div>

                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Enter password" pattern="^[a-zA-Z][a-zA-Z0-9-_.]{5,12}$" title="Password must be alphanumeric 6 to 12 chars" required/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" required/>
                                </div>
                                
                                <button type="submit" name="submit" class="btn btn-primary   m-t-20">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>
    
<?php include('includes/footer.php');?>

<?php } ?>