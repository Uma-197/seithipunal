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
            $pagetype = 'home';
            $pagetitle = $_POST['pagetitle'];
            $pagedetails = $_POST['pagedescription'];

            // Image upload logic
            if($_FILES['pageimage']['name']) {
                $imageName = $_FILES['pageimage']['name'];
                $imageTmpName = $_FILES['pageimage']['tmp_name'];
                $imageSize = $_FILES['pageimage']['size'];
                $imageError = $_FILES['pageimage']['error'];

                if($imageError === 0) {
                    $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
                    $allowedExt = array('jpg', 'jpeg', 'png', 'gif');
                    
                    if(in_array(strtolower($imageExt), $allowedExt)) {
                        // Using the original image name (with sanitized extension)
                        $imageNewName = basename($imageName); // Keep the original filename
                        $imageDestination = 'postimages/' . $imageNewName;
                        
                        // Move the uploaded image to the desired folder
                        if(move_uploaded_file($imageTmpName, $imageDestination)) {
                            // Image successfully uploaded, update the database with the new image name
                            $query = mysqli_query($con, "update tblpages set PageTitle='$pagetitle', Description='$pagedetails', PageImage='$imageNewName' where PageName='$pagetype'");
                        } else {
                            $error = "Failed to upload the image.";
                        }
                    } else {
                        $error = "Invalid image type. Please upload jpg, jpeg, png, or gif.";
                    }
                } else {
                    $error = "There was an error uploading the image.";
                }
            } else {
                // If no new image is uploaded, just update title and description
                $query = mysqli_query($con, "update tblpages set PageTitle='$pagetitle', Description='$pagedetails' where PageName='$pagetype'");
            }

            if($query)
            {
                $msg = "Home Page Successfully Updated";
            }
            else{
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
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Home Page</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Pages</li>
                        <li class="breadcrumb-item active">Home</li>
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
            $pagetype = 'home';
            $query = mysqli_query($con, "select PageTitle, PageImage, Description from tblpages where PageName='$pagetype'");
            while($row = mysqli_fetch_array($query)) {
        ?>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form name="home" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label">Page Title</label>
                                <input type="text" id="pagetitle" name="pagetitle" class="form-control" value="<?php echo htmlentities($row['PageTitle'])?>" placeholder="Enter Page title" required/>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Logo Image</label>
                                <input type="file" class="form-control" id="pageimage" name="pageimage">
                                <img src="postimages/<?php echo htmlentities($row['PageImage']);?>" width="300"/>
                                <br />
                            </div>

                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="summernote" name="pagedescription" id="summernote"><?php echo htmlentities($row['Description']); ?></textarea>
                            </div>
                            <?php } ?>
                            <button type="submit" name="update" class="btn btn-primary m-t-20">Update and Post</button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>

<?php } ?>
