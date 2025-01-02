<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
            if(isset($_POST['submit']))
            {
                $aid=intval($_GET['said']);
                $userrole=$_POST['userrole'];
                $email=$_POST['emailid'];

                // Determine the usertype based on userrole
                if ($userrole === 'admin') {
                    $usertype = '0';
                } elseif ($userrole === 'staff') {
                    $usertype = '2';
                } else {
                    // Optional: Handle other roles or set a default value
                    $usertype = '1'; // Example default value
                }
            
                $query=mysqli_query($con,"Update  tbladmin set AdminEmailId='$email', UserRole='$userrole', userType='$usertype'  where userType IN (0, 2) && id='$aid'");
                if($query)
                {
                    $msg="User Updated successfully ";
                }
                else{
                    $error="Something went wrong . Please try again.";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit User</h2>
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

            <?php 
                $aid=intval($_GET['said']);
                $query=mysqli_query($con,"Select * from  tbladmin where userType IN (0, 2) && id='$aid'");
                $cnt=1;
                while($row=mysqli_fetch_array($query))
                {
            ?>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="addsuadmin" method="post">
                                <div class="form-group">
                                    <label for="exampleInputusername">Username</label>
                                    <input type="text" placeholder="Enter Username"  name="sadminusername" id="sadminusername" class="form-control" value="<?php echo htmlentities($row['AdminUserName']);?>"  readonly>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Email Id</label>
                                    <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Enter email" value="<?php echo htmlentities($row['AdminEmailId']);?>" readonly/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" name="phonenumber" id="phonenumber" class="form-control" placeholder="Enter Phone Number" value="<?php echo htmlentities($row['PhoneNumber']);?>" readonly/>
                                </div>

                                <?php
                                    // Assuming $gender holds the saved value for gender from the database
                                    $gender = isset($row['Gender']) ? $row['Gender'] : ''; // Replace $row['Gender'] with your variable
                                ?>
                                <div>
                                    <label class="control-label">Gender</label><br>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="male" type="radio" <?php echo ($gender === 'male') ? 'checked' : ''; ?> readonly onclick="return false;">
                                        <span><i></i>Male</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="female" type="radio" <?php echo ($gender === 'female') ? 'checked' : ''; ?> readonly onclick="return false;">
                                        <span><i></i>Female</span>
                                    </label>
                                    <label class="fancy-radio">
                                        <input name="gender2" value="other" type="radio" <?php echo ($gender === 'other') ? 'checked' : ''; ?> readonly onclick="return false;">
                                        <span><i></i>Others</span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label for="userrole">User Role</label>
                                    <select class="form-control" name="userrole" id="userrole" required>
                                       <option value="">Select Role </option>
                                       <option value="admin" <?php echo (isset($row['UserRole']) && $row['UserRole'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                       <option value="staff" <?php echo (isset($row['UserRole']) && $row['UserRole'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" value="<?php echo htmlentities($row['Address']);?>" readonly/>
                                </div>

                                <div class="form-group">

                                    <?php
                                        // Assuming you fetched $row from the database where the password and IV are stored
                                        $encrypted_password = $row['AdminPassword'];
                                        $iv_hex = $row['Encryption_IV']; // The stored IV in hexadecimal format

                                        // AES Encryption Key (the same key used during encryption)
                                        $encryption_key = "xRUqKhsoZ5qV6y3kqARFJFdPqJvp7X2z"; // Use the same key for decryption

                                        // Convert the stored IV from hex to binary
                                        $iv = hex2bin($iv_hex);

                                        // Decrypt the password
                                        $decrypted_password = openssl_decrypt($encrypted_password, 'aes-256-cbc', $encryption_key, 0, $iv);
                                    ?>

                                    <label class="control-label">Password</label>
                                    <div class="password-container">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="<?php echo htmlentities($decrypted_password); ?>" readonly />
                                        <div class="input-group-append">
                                            <span class="input-group-text" onclick="togglePasswordVisibility()">
                                                <i id="toggleIcon" class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Creation Dtae</label>
                                       <input type="text" class="form-control" value="<?php echo htmlentities($row['CreationDate']);?>" name="cdate" readonly>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Updation date</label>
                                       <input type="text" class="form-control" value="<?php echo htmlentities($row['UpdationDate']);?>" name="udate" readonly>
                                </div>

                                 <?php } ?>
                                <button type="submit" name="submit" class="btn btn-primary   m-t-20">Update</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
    
<?php include('includes/footer.php');?>

<?php } ?>