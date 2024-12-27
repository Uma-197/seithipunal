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
                $catid=intval($_GET['cid']);
                $adtitle = $_POST['adtitle'];
                $adurl = $_POST['adurl'];
                $startdate = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $addescription = $_POST['addescription'];
           
                $imgfile=$_FILES["adimage"]["name"];
                // get the image extension
                $fileinfo = pathinfo($imgfile);
                $extension = strtolower($fileinfo['extension']);
                // allowed extensions
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                // Validation for allowed extensions .in_array() function searches an array for a specific value.
                if(!in_array($extension,$allowed_extensions))
                {
                    $error="Invalid format. Only jpg / jpeg/ png /gif format allowed";
                }
                else
                {
                    // Use the actual file name
                    $imgnewfile = $imgfile;

                    // Code for move image into directory
                    move_uploaded_file($_FILES["adimage"]["tmp_name"],"advertisements/".$imgnewfile);
              
                    $query=mysqli_query($con,"Update  tbladvertisements set AdTitle='$adtitle',  AdImage='$imgnewfile',  AdUrl='$adurl',  StartDate='$startdate',  EndDate='$enddate',  AdDescription='$addescription'  where id='$catid'");
                    if($query)
                    {
                        $msg="Advertisement Updated Successfully";
                    }
                    else{
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
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Advertisement</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item active">Advertisement</li>
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
            $catid=intval($_GET['cid']);
            $query=mysqli_query($con,"Select id,AdTitle,AdImage,AdUrl,StartDate,EndDate,AdDescription,PostingDate,UpdationDate from  tbladvertisements where Is_Active=1 and id='$catid'");
            $cnt=1;
            while($row=mysqli_fetch_array($query))
            {
        ?>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form name="advertisement" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label">Advertisement Title</label>
                                    <input type="text" name="adtitle" id="adtitle" value="<?php echo htmlentities($row['AdTitle'])?>" class="form-control" placeholder="Enter Advertisement Title" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Advertisement URL</label>
                                    <input type="url" name="adurl" id="adurl" value="<?php echo htmlentities($row['AdUrl'])?>" class="form-control" placeholder="Enter Advertisement URL" required/>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Advertisement Image</label>
                                <input type="file" class="form-control" id="adimage" name="adimage">
                                <img src="advertisements/<?php echo htmlentities($row['AdImage']);?>" width="300"/>
                                <br />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Start Date</label>
                                    <input type="date" name="startdate" id="startdate" value="<?php echo date('Y-m-d', strtotime($row['StartDate'])); ?>" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">End Date</label>
                                    <input type="date" name="enddate" id="enddate" value="<?php echo date('Y-m-d', strtotime($row['EndDate'])); ?>" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Advertisement Description</label>
                                <textarea class="summernote" name="addescription" id="summernote"><?php echo htmlentities($row['AdDescription']); ?></textarea>
                            </div>
                            <?php } ?>
                            <button type="submit" name="update" class="btn btn-primary m-t-20">Update</button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>

<?php } ?>
