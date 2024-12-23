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
                                    <label for="userrole">User Role</label>
                                    <select class="form-control" name="userrole" id="userrole" required>
                                       <option value="">Select Role </option>
                                       <option value="admin" <?php echo (isset($row['UserRole']) && $row['UserRole'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                       <option value="staff" <?php echo (isset($row['UserRole']) && $row['UserRole'] == 'staff') ? 'selected' : ''; ?>>Staff</option>
                                    </select>
                                 </div>
                                <div class="form-group">
                                    <label class="control-label">Email Id</label>
                                    <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Enter email" value="<?php echo htmlentities($row['AdminEmailId']);?>" readonly/>
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
                                <button type="submit" name="submit" class="btn btn-block btn-primary   m-t-20">Update</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>
    
<?php include('includes/footer.php');?>

<?php } ?>