<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
   
        // Code for Forever deletionparmdel
        if($_GET['action']=='del' && $_GET['rid'])
        {
            $id=intval($_GET['rid']);
            $query = mysqli_query($con, "UPDATE tbladmin SET Is_Active = 0 WHERE id = '$id' AND userType IN (0, 2)");
            if ($query) {
                $delmsg = "User deactivated successfully";
            } else {
                $error = "Something went wrong. Please try again.";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> User Reports</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">User Reports</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>User Reports</h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover m-b-0 c_list">
                                <thead>
                                    <tr>
                                        <!-- <th>
                                            <label class="fancy-checkbox">
                                                <input class="select-all" type="checkbox" name="checkbox">
                                                <span></span>
                                            </label>
                                        </th> -->
                                        <th>#</th>
                                        <th>Name</th>                                    
                                        <th>Email Id</th>                                    
                                        <th>Post Counts</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php 
                                            $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE Is_Active = 1");
                                            $cnt=1;
                                            while($row=mysqli_fetch_array($query))
                                            {
                                                $userName = $row['AdminUserName'];
                                                
                                                // Separate query to count posts for each user by matching username
                                                $postCountQuery = mysqli_query($con, "SELECT COUNT(*) AS postCount FROM tblposts WHERE postedBy = '$userName'");
                                                
                                                // If no rows are returned, post count will be 0
                                                if($postCountQuery && mysqli_num_rows($postCountQuery) > 0) {
                                                    $postCountResult = mysqli_fetch_assoc($postCountQuery);
                                                    $postCount = $postCountResult['postCount'];
                                                } else {
                                                    $postCount = 0; // Set default to 0 if no posts found
                                                }
                                        ?>
                                    <tr>
                                        <!-- <td style="width: 50px;">
                                           <label class="fancy-checkbox">
                                                <input class="checkbox-tick" type="checkbox" name="checkbox">
                                                <span></span>
                                            </label>
                                        </td> -->
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td>
                                            <p class="c_name"><?php echo htmlentities($row['AdminUserName']);?> <span class="badge badge-info m-l-10 hidden-sm-down"><?php echo ucfirst(htmlentities($row['UserRole'])); ?></span></p>
                                        </td>
                                        <td>
                                            <span class="phone"><i class="zmdi zmdi-phone m-r-10"></i><?php echo htmlentities($row['AdminEmailId']);?></span>
                                        </td>                                   
                                        <td>
                                            <address><i class="zmdi zmdi-pin"></i><?php echo htmlentities($postCount);?></address>
                                        </td>
                                    </tr>
                                    <?php
                                       $cnt++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php include('includes/footer.php');?>

<?php } ?>
