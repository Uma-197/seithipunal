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
                $adtitle = $_POST['adtitle'];
                $adurl = $_POST['adurl'];
                $startdate = $_POST['startdate'];
                $enddate = $_POST['enddate'];
                $addescription = $_POST['addescription'];
                $status=1;

                // Handle file upload for advertisement image
                if(isset($_FILES["adimage"]) && $_FILES["adimage"]["name"] != "") {
                    $adimage = $_FILES["adimage"]["name"];
                    $adimage_temp = $_FILES["adimage"]["tmp_name"];
                    $adimage_ext = pathinfo($adimage, PATHINFO_EXTENSION);
                    $adimage_new = md5($adimage) . '.' . $adimage_ext;
                    move_uploaded_file($adimage_temp, "advertisements/" . $adimage_new); // Save to ads folder
                }
                
                $query=mysqli_query($con,"insert into tbladvertisements(AdTitle,AdImage,AdUrl,StartDate,EndDate,AdDescription,Is_Active) values('$adtitle', '$adimage_new', '$adurl', '$startdate', '$enddate', '$addescription', '$status')");

                if($query)
                {
                    $msg="Advertisement created ";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Advertisement</h2>
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

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <form name="advertisement" method="post">
                                <div class="form-group">
                                    <label class="control-label">Advertisement Title</label>
                                    <input type="text" name="adtitle" id="adtitle" value="" class="form-control" placeholder="Enter Advertisement Title" required/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Advertisement URL</label>
                                    <input type="url" name="adurl" id="adurl" value="" class="form-control" placeholder="Enter Advertisement URL" required/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Advertisement Image</label>
                                    <input type="file" class="form-control" id="adimage" name="adimage"  required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Start Date</label>
                                    <input type="date" name="startdate" id="startdate" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label class="control-label">End Date</label>
                                    <input type="date" name="enddate" id="enddate" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Advertisement Description</label>
                                    <textarea class="summernote" name="addescription" id="summernote" required></textarea>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary   m-t-20">Add Advertisement</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>

    <script>
    document.querySelector('form').addEventListener('submit', function(e) {
        var startdate = document.getElementById('startdate').value;
        var enddate = document.getElementById('enddate').value;

        if (new Date(enddate) < new Date(startdate)) {
            alert("End date cannot be earlier than start date.");
            e.preventDefault(); // Prevent form submission
        }
    });
</script>


    
<?php include('includes/footer.php');?>

<?php } ?>