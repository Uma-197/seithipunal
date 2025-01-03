<?php 
   session_start();
   include('includes/config.php');
   error_reporting(0);
   if(strlen($_SESSION['login'])==0)
      { 
         header('location:index.php');
   }
   else{
   
   if($_GET['action'] == 'del')
   {
      $postid=intval($_GET['pid']);
      $query=mysqli_query($con,"update tblposts set Is_Active=0 where id='$postid'");
      if($query)
      {
         $msg="Post Deleted ";
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
<style>
    td.details-control {
        background: url('assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('assets/images/details_close.png') no-repeat center center;
    }
    td.postimg {
        width: 10%;
    }
</style>


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Posts</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Post</li>
                            <li class="breadcrumb-item active">Manage Posts</li>
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
                        <!-- <div class="header">
                            <h2>Table Tools<small>Basic example without any additional modification classes</small> </h2>
                        </div> -->
                        <div class="body">
						    <div class="table-responsive">
                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Posted By</th>
                                        <th>Last Updated By</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Check user type from session
                                        $userType = $_SESSION['utype']; // Assuming 'utype' stores the user type: 0 for super admin, 1 for normal user
                                        $loggedInUser = $_SESSION['login'];

                                        // Modify query based on user type
                                        if ($userType == '1') { // Super admin
                                            $query = mysqli_query($con, "SELECT tblposts.id as postid, tblposts.PostTitle as title, tblposts.PostImage, tblposts.postedBy, tblposts.lastUpdatedBy, tblcategory.CategoryName as category, tblsubcategory.Subcategory as subcategory 
                                                                         FROM tblposts 
                                                                         LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId 
                                                                         LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId 
                                                                         WHERE tblposts.Is_Active = 1");
                                        } else { // Normal user
                                            $query = mysqli_query($con, "SELECT tblposts.id as postid, tblposts.PostTitle as title, tblposts.PostImage, tblposts.postedBy, tblposts.lastUpdatedBy, tblcategory.CategoryName as category, tblsubcategory.Subcategory as subcategory 
                                                                         FROM tblposts 
                                                                         LEFT JOIN tblcategory ON tblcategory.id = tblposts.CategoryId 
                                                                         LEFT JOIN tblsubcategory ON tblsubcategory.SubCategoryId = tblposts.SubCategoryId 
                                                                         WHERE tblposts.Is_Active = 1 AND tblposts.postedBy = '$loggedInUser'");
                                        }

                                        // Fetch results
                                        $rowcount = mysqli_num_rows($query);
                                        if($rowcount==0)
                                        {
                                    ?>
                                    <tr>
                                       <td colspan="4" align="center">
                                          <h3 style="color:red">No record found</h3>
                                       </td>
                                    </tr>
                                    <?php 
                                      } else {
                                      while($row=mysqli_fetch_array($query))
                                      {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row['postid']);?></td>
                                        <td class="postimg"><img class="img-fluid img-thumbnail" src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300"/></td>
                                        <td><?php echo htmlentities($row['title']);?></td>
                                        <td><?php echo htmlentities($row['postedBy']);?></td>
                                        <td><?php echo htmlentities($row['lastUpdatedBy']);?></td>
                                        <td><?php echo htmlentities($row['category']);?></td>
                                        <td><?php echo htmlentities($row['subcategory']);?></td>
                                        <td>
                                            <a  class="btn btn-primary btn-sm" href="edit-post.php?pid=<?php echo htmlentities($row['postid']);?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <?php if ($_SESSION['utype'] == '1' || $_SESSION['utype'] == '0'): ?> 
                                             &nbsp;
                                            <a class="btn btn-danger btn-sm" href="manage-posts.php?pid=<?php echo htmlentities($row['postid']);?>&&action=del"> 
                                                <i class="fa fa-trash-o"></i>
                                            </a> 
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php } }?>
                                </tbody>
                                </table>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('includes/footer.php');?>

<?php } ?>