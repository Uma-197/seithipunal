<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
            if($_GET['action']=='del' && $_GET['scid'])
            {
                $id=intval($_GET['scid']);
                $query=mysqli_query($con,"update  tblsubcategory set Is_Active='0' where SubCategoryId='$id'");
                $msg="Category deleted ";
            }
            // Code for restore
            if($_GET['resid'])
            {
                $id=intval($_GET['resid']);
                $query=mysqli_query($con,"update  tblsubcategory set Is_Active='1' where SubCategoryId='$id'");
                $msg="Category restored successfully";
            }
   
            // Code for Forever deletionparmdel
            if($_GET['action']=='perdel' && $_GET['scid'])
            {
                $id=intval($_GET['scid']);
                $query=mysqli_query($con,"delete from   tblsubcategory  where SubCategoryId='$id'");
                $delmsg="Category deleted forever";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage SubCategories</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Category</li>
                            <li class="breadcrumb-item active">Manage SubCategories</li>
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
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Posting Date</th>
                                        <th>Last Update Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                       $query=mysqli_query($con,"Select tblcategory.CategoryName as catname,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=1");
                                       $cnt=1;
                                       $rowcount=mysqli_num_rows($query);
                                       if($rowcount==0)
                                       {
                                    ?>
                                    <tr>
                                       <td colspan="7" align="center">
                                          <h3 style="color:red">No record found</h3>
                                       </td>
                                    <tr>
                                        <?php 
                                            } else {
                                          
                                            while($row=mysqli_fetch_array($query))
                                            {
                                        ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($row['catname']);?></td>
                                        <td><?php echo htmlentities($row['subcatname']);?></td>
                                        <td><?php echo htmlentities($row['subcatpostingdate']);?></td>
                                        <td><?php echo htmlentities($row['subcatupdationdate']);?></td>
                                        <td>
                                            <a href="edit-subcategory.php?scid=<?php echo htmlentities($row['subcatid']);?>"  class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                                <?php if ($_SESSION['utype'] == '1' || $_SESSION['utype'] == '0'): ?> 
                                            &nbsp;
                                            <a href="manage-subcategory.php?scid=<?php echo htmlentities($row['subcatid']);?>&&action=del" class="btn btn-danger btn-sm"> 
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <?php endif; ?> 
                                       </td>
                                    </tr>
                                    <?php
                                       $cnt++;
                                    } } ?>
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