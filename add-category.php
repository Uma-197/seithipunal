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
                $category=$_POST['category'];
                $slug=$_POST['slug'];
                $description=$_POST['description'];
                $status=1;

                
                $query=mysqli_query($con,"insert into tblcategory(CategoryName,Slug,Description,Is_Active) values('$category', '$slug', '$description','$status')");

                if($query)
                {
                    $msg="Category created ";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Category</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Category</li>
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
                            <form name="category" method="post">
                                <div class="form-group">
                                    <label class="control-label">Category</label>
                                    <input type="text" name="category" id="category" value="" class="form-control" placeholder="Enter category title" required onkeyup="updateSlug()"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Slug</label>
                                    <input type="text" name="slug" id="slug" value="" class="form-control" placeholder="Slug will be auto-generated" readonly/>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label">Category Description</label>
                                    <textarea class="summernote" name="pagedescription" id="summernote"></textarea>
                                </div> -->
                                <button type="submit" name="submit" class="btn btn-primary   m-t-20">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>

    <script>
        function updateSlug() {
            let categoryInput = document.getElementById('category').value;
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