<?php 
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
            if(isset($_POST['update']))
            {
                $pagetype='terms';
                $pagetitle=$_POST['pagetitle'];
                $pagedetails=$_POST['pagedescription'];

                $query=mysqli_query($con,"update tblpages set PageTitle='$pagetitle',Description='$pagedetails' where PageName='$pagetype' ");
                if($query)
                {
                    $msg="Terms Page Successfully Updated ";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Terms Page</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active">Terms</li>
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
                $pagetype='terms';
                $query=mysqli_query($con,"select PageTitle,Description from tblpages where PageName='$pagetype'");
                while($row=mysqli_fetch_array($query))
                {

            ?>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="terms" method="post">
                                <div class="form-group">
                                    <label class="control-label">Page Title</label>
                                    <input type="text" id="pagetitle" name="pagetitle" class="form-control" value="<?php echo htmlentities($row['PageTitle'])?>" placeholder="Enter Page title" required/>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <textarea class="summernote" name="pagedescription" id="summernote"><?php echo htmlentities($row['Description']); ?></textarea>
                                </div>
                                <?php } ?>
                                <button type="submit" name="update" class="btn btn-primary   m-t-20">Update and Post</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>
    
<?php include('includes/footer.php');?>

<?php } ?>