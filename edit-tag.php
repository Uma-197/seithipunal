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
                $tagid=intval($_GET['tid']);
                $tag=$_POST['tag'];
                $slug=$_POST['slug'];
                $description=$_POST['description'];
                $query=mysqli_query($con,"Update  tbltags set TagName='$tag', Slug='$slug' ,Description='$description' where id='$tagid'");
                if($query)
                {
                    $msg="Tag Updated Successfully ";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Tag</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Tag</li>
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
                            <?php 
                                $tagid=intval($_GET['tid']);
                                $query=mysqli_query($con,"Select id,TagName,Slug,Description,PostingDate,UpdationDate from  tbltags where Is_Active=1 and id='$tagid'");
                                $cnt=1;
                                while($row=mysqli_fetch_array($query))
                                {
                            ?>
                            <form name="tag" method="post">
                                <div class="form-group">
                                    <label class="control-label">Tag</label>
                                    <input type="text" name="tag" id="tag" value="<?php echo htmlentities($row['TagName']);?>" class="form-control" placeholder="Enter tag title" required onkeyup="updateSlug()"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Slug</label>
                                    <input type="text" name="slug" id="slug" value="<?php echo htmlentities($row['Slug']);?>" class="form-control" placeholder="Slug will be auto-generated" readonly/>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label">Tag Description</label>
                                    <textarea class="summernote" name="pagedescription" id="summernote"><?php echo htmlentities($row['Description']);?></textarea>
                                </div> -->
                                <?php } ?>
                                <button type="submit" name="submit" class="btn btn-block btn-primary   m-t-20">Update</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>

    <script>
        function updateSlug() {
            let categoryInput = document.getElementById('tag').value;
            let slugInput = categoryInput
                .toLowerCase() // Convert to lowercase
                .trim()        // Remove leading/trailing whitespace
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/[^a-z0-9\-]/g, ''); // Remove non-alphanumeric characters except hyphens
            document.getElementById('slug').value = slugInput;
        }
    </script>
    
<?php include('includes/footer.php');?>

<?php } ?>