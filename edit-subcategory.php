<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
            if(isset($_POST['submitsubcat']))
            {
                $subcatid=intval($_GET['scid']);    
                $categoryid=$_POST['category'];
                $subcatname=$_POST['subcategory'];
                $subslugname=$_POST['subslug'];
                $subcatdescription=$_POST['sucatdescription'];
                $query=mysqli_query($con,"update tblsubcategory set CategoryId='$categoryid',Subcategory='$subcatname',SubSlug='$subslugname',SubCatDescription='$subcatdescription' where SubCategoryId='$subcatid'");
                if($query)
                {
                    $msg="Sub-Category created ";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Sub-Category</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Sub-Category</li>
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
                                //fetching Category details
                                $subcatid=intval($_GET['scid']);
                                $query=mysqli_query($con,"Select tblcategory.CategoryName as catname,
                                    tblcategory.id as catid,
                                    tblsubcategory.Subcategory as subcatname,
                                    tblsubcategory.SubSlug as subslugname,
                                    tblsubcategory.SubCatDescription as SubCatDescription,
                                    tblsubcategory.PostingDate as subcatpostingdate,
                                    tblsubcategory.UpdationDate as subcatupdationdate,
                                    tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=1 and  SubCategoryId='$subcatid'");
                                $cnt=1;
                                while($row=mysqli_fetch_array($query))
                                {
                              
                            ?>

                            <form name="subcategory" method="post">
                                <div class="form-group">
                                    <label class="control-label">Category</label>
                                    <select class="form-control" name="category" required>
                                        <!-- <option value="">Select Category </option> -->
                                        <option value="<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['catname']);?></option>
                                        <?php
                                            // Feching active categories
                                            $ret=mysqli_query($con,"select id,CategoryName from  tblcategory where Is_Active=1");
                                            while($result=mysqli_fetch_array($ret))
                                            {    
                                        ?>
                                        <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['CategoryName']);?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Sub Category</label>
                                    <input type="text" name="subcategory" id="subcategory" value="<?php echo htmlentities($row['subcatname']);?>" class="form-control" placeholder="Enter subcategory title" required onkeyup="updateSlug()"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Sub-Slug</label>
                                    <input type="text" name="subslug" id="subslug" value="<?php echo htmlentities($row['subslugname']);?>" class="form-control" placeholder="Slug will be auto-generated" readonly/>
                                </div>
                                <?php } ?>
                                <!-- <div class="form-group">
                                    <label class="control-label">Sub-Category Description</label>
                                    <textarea class="summernote" name="pagedescription" id="summernote"></textarea>
                                </div> -->
                                <button type="submit" name="submitsubcat" class="btn btn-block btn-primary   m-t-20">Update</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>

    <script>
        function updateSlug() {
            let categoryInput = document.getElementById('subcategory').value;
            let slugInput = categoryInput
                .toLowerCase() // Convert to lowercase
                .trim()        // Remove leading/trailing whitespace
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/[^a-z0-9\-]/g, ''); // Remove non-alphanumeric characters except hyphens
            document.getElementById('subslug').value = slugInput;
        }
    </script>
    
<?php include('includes/footer.php');?>

<?php } ?>