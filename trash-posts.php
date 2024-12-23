<?php 
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{   
   
            if($_GET['action'] == 'restore')
            {
                $postid=intval($_GET['pid']);
                $query=mysqli_query($con,"update tblposts set Is_Active=1 where id='$postid'");
                if($query)
                {
                    $msg="Post restored successfully ";
                }
                else{
                    $error="Something went wrong . Please try again.";    
                } 
            }
   
            // Code for Forever deletionparmdel
            if($_GET['presid'])
            {
                $id=intval($_GET['presid']);
                $query=mysqli_query($con,"delete from  tblposts  where id='$id'");
                $delmsg="Post deleted forever";
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
</style>


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Trash Posts</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Trash Posts</li>
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
                    <?php if($delmsg){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                        <strong>Well done!</strong> <?php echo htmlentities($delmsg);?>
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
                                        <!-- <th>Image</th> -->
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
                                       $query=mysqli_query($con,"select tblposts.id as postid,tblposts.PostTitle as title,tblposts.PostImage,tblposts.postedBy,tblposts.lastUpdatedBy,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=0 ");
                                       $rowcount=mysqli_num_rows($query);
                                       if($rowcount==0)
                                       {
                                    ?>
                                    <tr>
                                        <td colspan="7" align="center">
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
                                        <!-- <td class="postimg"><img class="img-fluid img-thumbnail" src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300"/></td> -->
                                        <td><?php echo htmlentities($row['title']);?></td>
                                        <td><?php echo htmlentities($row['postedBy']);?></td>
                                        <td><?php echo htmlentities($row['lastUpdatedBy']);?></td>
                                        <td><?php echo htmlentities($row['category']);?></td>
                                        <td><?php echo htmlentities($row['subcategory']);?></td>
                                        <td>
                                          <a href="trash-posts.php?pid=<?php echo htmlentities($row['postid']);?>&&action=restore" onclick="return confirm('Do you really want to restore ?')"> <i class="ion-arrow-return-right" title="Restore this Post"></i></a>
                                          &nbsp;
                                          <a href="trash-posts.php?presid=<?php echo htmlentities($row['postid']);?>&&action=perdel" onclick="return confirm('Do you really want to delete ?')"><i class="fa fa-trash-o" style="color: #f05050" title="Permanently delete this post"></i></a> 
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