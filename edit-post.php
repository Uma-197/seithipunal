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
         $posttitle=$_POST['posttitle'];
         $tamiltitle=$_POST['tamiltitle'];
         $catid=$_POST['category'];
         $subcatid=$_POST['subcategory'];
         $tagid = $_POST['maintag'];
         $htag = $_POST['hashtag'];
         $district = $_POST['district'];
         $latestnews = $_POST['latestnews'];
         $postdetails=$_POST['postdescription'];
         $shortdescription=$_POST['shortdescription'];
         $lastuptdby=$_POST['loggedInUserName'];
         $poststatus = $_POST['poststatus'];
         $arr = explode(" ",$posttitle);
         $url=implode("-",$arr);
         $status=1;
         $postid=intval($_GET['pid']);

         // Handle checkbox options
         $optionsArray = isset($_POST['options']) ? $_POST['options'] : [];
         $options = implode(',', $optionsArray); // Convert array to a comma-separated string

         $query=mysqli_query(
            $con,"update tblposts set 
            PostTitle='$posttitle',
            TamilTitle='$tamiltitle',
            CategoryId='$catid',
            SubCategoryId='$subcatid',
            TagId='$tagid',
            HashTag = '$htag',
            District = '$district',
            LatestNews = '$latestnews',
            PostDetails='$postdetails',
            ShortDescription = '$shortdescription',
            PostStatus = '$poststatus',
            PostUrl='$url',
            Is_Active='$status',
            lastUpdatedBy='$lastuptdby',
            Options='$options' 
            where id='$postid'"
         );
         if($query)
         {
            $msg="Post updated ";
         }
         else{
            $error="Something went wrong . Please try again.";    
         } 
      
      }
?>

<?php include('includes/topheader.php');?>
<script>
   function getSubCat(val) {
      $.ajax({
         type: "POST",
         url: "get-subcategory.php",
         data:'catid='+val,
         success: function(data){
            $("#subcategory").html(data);
         }
      });
   }     
</script>

<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<!-- Left Sidebar End -->

    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Post</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Post</li>
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
                $postid=intval($_GET['pid']);
                $query=mysqli_query($con,"select 
                   tblposts.id as postid,
                   tblposts.PostImage,
                   tblposts.PostVideo,
                   tblposts.PostTitle as title,
                   tblposts.TamilTitle,
                   tblposts.LatestNews,
                   tblposts.HashTag,
                   tblposts.District,
                   tblposts.Options,
                   tblposts.PostDetails,
                   tblposts.ShortDescription,
                   tblposts.PostStatus,
                   tbltags.TagName as maintag,tbltags.id as tagid,
                   tblcategory.CategoryName as category,tblcategory.id as catid,
                   tblsubcategory.SubCategoryId as subcatid,tblsubcategory.Subcategory as subcategory 
                   from tblposts 
                   left join tbltags on tbltags.id = tblposts.TagId
                   left join tblcategory on tblcategory.id=tblposts.CategoryId 
                   left join tblsubcategory on tblsubcategory.SubCategoryId=tblposts.SubCategoryId 
                   where tblposts.id='$postid' and tblposts.Is_Active=1 ");
                while($row=mysqli_fetch_array($query))
                {
            ?>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <!-- <div class="header">
                            <h2>Color Pickers <small>Taken from <a href="https://github.com/mjolnic/bootstrap-colorpicker/" target="_blank">github.com/mjolnic/bootstrap-colorpicker</a></small> </h2>                            
                        </div> -->
                        <div class="body">
                            <form name="addpost" method="post" enctype="multipart/form-data">
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Is Latest News</label>
                                        <select class="form-control" name="latestnews" id="latestnews" required>
                                            <option value="">Select </option>
                                            <option value="yes" <?php echo (isset($row['LatestNews']) && $row['LatestNews'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
                                            <option value="no" <?php echo (isset($row['LatestNews']) && $row['LatestNews'] == 'no') ? 'selected' : ''; ?>>No</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label class="control-label">Post Title</label>                                   
                                        <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter Title" value="<?php echo htmlentities($row['title']);?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Post Title(Tamil)</label>                                   
                                        <input type="text" class="form-control" id="tamiltitle" name="tamiltitle" placeholder="Enter Tamil Title" value="<?php echo htmlentities($row['TamilTitle']);?>"required>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                                            <option value="<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['category']);?></option>
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
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Sub Category</label>
                                        <select class="form-control" name="subcategory" id="subcategory" required>
                                            <option value="<?php echo htmlentities($row['subcatid']);?>"><?php echo htmlentities($row['subcategory']);?></option>
                                        </select> 
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Main Tag</label>
                                        <select class="form-control" name="maintag" id="maintag" required>
                                            <option value="<?php echo htmlentities($row['tagid']);?>"><?php echo htmlentities($row['maintag']);?></option>
                                             <?php
                                                // Feching active categories
                                                $ret=mysqli_query($con,"select id,TagName from  tbltags where Is_Active=1");
                                                while($result=mysqli_fetch_array($ret))
                                                {    
                                             ?>
                                             <option value="<?php echo htmlentities($result['id']);?>"><?php echo htmlentities($result['TagName']);?></option>
                                             <?php } ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Tags</label>
                                        <select class="form-control" name="hashtag" id="hashtag" required>
                                            <option value="">Select Tag </option>
                                            <option value="htag" <?php echo (isset($row['HashTag']) && $row['HashTag'] == 'htag') ? 'selected' : ''; ?>>Hashtag</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">District</label>
                                        <select class="form-control" name="district" id="district" required>
                                          <option value="">Select District</option>
                                          <option value="1" <?php echo (isset($row['District']) && $row['District'] == '1') ? 'selected' : ''; ?>>காஞ்சிபுரம்</option>
                                          <option value="2" <?php echo (isset($row['District']) && $row['District'] == '2') ? 'selected' : ''; ?>>திருவள்ளூர்</option>
                                          <option value="3" <?php echo (isset($row['District']) && $row['District'] == '3') ? 'selected' : ''; ?>>வேலூர்</option>
                                          <option value="4" <?php echo (isset($row['District']) && $row['District'] == '4') ? 'selected' : ''; ?>>திருவண்ணாமலை</option>
                                          <option value="5" <?php echo (isset($row['District']) && $row['District'] == '5') ? 'selected' : ''; ?>>விழுப்புரம்</option>
                                          <option value="6" <?php echo (isset($row['District']) && $row['District'] == '6') ? 'selected' : ''; ?>>சேலம்</option>
                                          <option value="7" <?php echo (isset($row['District']) && $row['District'] == '7') ? 'selected' : ''; ?>>நாமக்கல்</option>
                                          <option value="8" <?php echo (isset($row['District']) && $row['District'] == '8') ? 'selected' : ''; ?>>தர்மபுரி</option>
                                          <option value="9" <?php echo (isset($row['District']) && $row['District'] == '9') ? 'selected' : ''; ?>>கிருஷ்ணகிரி</option>
                                          <option value="10" <?php echo (isset($row['District']) && $row['District'] == '10') ? 'selected' : ''; ?>>ஈரோடு</option>
                                          <option value="11" <?php echo (isset($row['District']) && $row['District'] == '11') ? 'selected' : ''; ?>>நீலகிரி</option>
                                          <option value="12" <?php echo (isset($row['District']) && $row['District'] == '12') ? 'selected' : ''; ?>>திருச்சி</option>
                                          <option value="13" <?php echo (isset($row['District']) && $row['District'] == '13') ? 'selected' : ''; ?>>கரூர்</option>
                                          <option value="14" <?php echo (isset($row['District']) && $row['District'] == '14') ? 'selected' : ''; ?>>பெரம்பலூர்</option>
                                          <option value="15" <?php echo (isset($row['District']) && $row['District'] == '15') ? 'selected' : ''; ?>>அரியலூர்</option>
                                          <option value="16" <?php echo (isset($row['District']) && $row['District'] == '16') ? 'selected' : ''; ?>>புதுக்கோட்டை</option>
                                          <option value="17" <?php echo (isset($row['District']) && $row['District'] == '17') ? 'selected' : ''; ?>>தஞ்சாவூர்</option>
                                          <option value="18" <?php echo (isset($row['District']) && $row['District'] == '18') ? 'selected' : ''; ?>>திருவாரூர்</option>
                                          <option value="19" <?php echo (isset($row['District']) && $row['District'] == '19') ? 'selected' : ''; ?>>நாகப்பட்டினம்</option>
                                          <option value="20" <?php echo (isset($row['District']) && $row['District'] == '20') ? 'selected' : ''; ?>>திண்டுக்கல்</option>
                                          <option value="21" <?php echo (isset($row['District']) && $row['District'] == '21') ? 'selected' : ''; ?>>தேனி</option>
                                          <option value="22" <?php echo (isset($row['District']) && $row['District'] == '22') ? 'selected' : ''; ?>>ராமநாதபுரம்</option>
                                          <option value="23" <?php echo (isset($row['District']) && $row['District'] == '23') ? 'selected' : ''; ?>>சிவகங்கை</option>
                                          <option value="24" <?php echo (isset($row['District']) && $row['District'] == '24') ? 'selected' : ''; ?>>விருதுநகர்</option>
                                          <option value="25" <?php echo (isset($row['District']) && $row['District'] == '25') ? 'selected' : ''; ?>>திருநெல்வேலி</option>
                                          <option value="26" <?php echo (isset($row['District']) && $row['District'] == '26') ? 'selected' : ''; ?>>தூத்துக்குடி</option>
                                          <option value="27" <?php echo (isset($row['District']) && $row['District'] == '27') ? 'selected' : ''; ?>>கன்னியாகுமரி</option>
                                          <option value="28" <?php echo (isset($row['District']) && $row['District'] == '28') ? 'selected' : ''; ?>>திருப்பூர்</option>
                                          <option value="29" <?php echo (isset($row['District']) && $row['District'] == '29') ? 'selected' : ''; ?>>கடலூர்</option>
                                          <option value="30" <?php echo (isset($row['District']) && $row['District'] == '30') ? 'selected' : ''; ?>>மதுரை</option>
                                          <option value="31" <?php echo (isset($row['District']) && $row['District'] == '31') ? 'selected' : ''; ?>>சென்னை</option>
                                          <option value="32" <?php echo (isset($row['District']) && $row['District'] == '32') ? 'selected' : ''; ?>>கோவை</option>
                                          <option value="33" <?php echo (isset($row['District']) && $row['District'] == '33') ? 'selected' : ''; ?>>செங்கல்பட்டு</option>
                                          <option value="34" <?php echo (isset($row['District']) && $row['District'] == '34') ? 'selected' : ''; ?>>திருப்பத்தூர்</option>
                                          <option value="35" <?php echo (isset($row['District']) && $row['District'] == '35') ? 'selected' : ''; ?>>இராணிப்பேட்டை</option>
                                          <option value="36" <?php echo (isset($row['District']) && $row['District'] == '36') ? 'selected' : ''; ?>>கள்ளக்குறிச்சி</option>
                                          <option value="37" <?php echo (isset($row['District']) && $row['District'] == '37') ? 'selected' : ''; ?>>தென்காசி</option>
                                          <option value="38" <?php echo (isset($row['District']) && $row['District'] == '38') ? 'selected' : ''; ?>>மயிலாடுதுறை</option>
                                        </select> 
                                    </div>

                                    <?php
                                       // Fetch current post options from the database and convert them into an array
                                       $postOptions = isset($row['Options']) ? explode(',', $row['Options']) : [];
                                    ?>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Options</label><br>
                                            <label>
                                                <input id="IsVideo" type="checkbox" name="options[]" value="IsVideo" 
                                                <?php echo in_array('IsVideo', $postOptions) ? 'checked' : ''; ?>> 
                                                <label for="IsVideo">Is Video?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsGallery" type="checkbox" name="options[]" value="IsGallery" 
                                                <?php echo in_array('IsGallery', $postOptions) ? 'checked' : ''; ?>> <label for="IsGallery">Is Gallery?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsFlash" type="checkbox" name="options[]" value="IsFlash" 
                                                <?php echo in_array('IsFlash', $postOptions) ? 'checked' : ''; ?>> <label for="IsFlash">Is flash news?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsScroll" type="checkbox" name="options[]" value="IsScroll" 
                                                <?php echo in_array('IsScroll', $postOptions) ? 'checked' : ''; ?>> <label for="IsScroll">Is scroller news?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsRecent" type="checkbox" name="options[]" value="IsRecent" 
                                                <?php echo in_array('IsRecent', $postOptions) ? 'checked' : ''; ?>> <label for="IsRecent">Is recent news?</label>
                                            </label>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
                                        <img src="postimages/<?php echo htmlentities($row['PostImage']);?>" width="300"/>
                                        <br />
                                        <a href="change-image.php?pid=<?php echo htmlentities($row['postid']);?>">Update Image</a>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="m-b-30 m-t-0 header-title"><b>Feature Video</b></h4>
                                        <!-- Display the video -->
                                        <?php if (!empty($row['PostVideo'])) { ?>
                                            <video width="300" controls>
                                                <source src="postvideos/<?php echo htmlentities($row['PostVideo']); ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <br />
                                        <?php } else { ?>
                                            <p>No video uploaded for this post.</p>
                                        <?php } ?>
                                        <a href="change-video.php?pid=<?php echo htmlentities($row['postid']);?>">Update Video</a>
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label">Full Description</label>
                                    <textarea class="summernote" name="postdescription" id="summernote" required><?php echo htmlentities($row['PostDetails']);?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Short Description(Full News in Tamil Maximum 220 Characters)</label>
                                    <textarea class="summernote" name="shortdescription" id="summernote2" maxlength="220" required><?php echo htmlentities($row['ShortDescription']);?></textarea>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        
                                        <?php
                                           // Start the session
                                           if (session_status() == PHP_SESSION_NONE) {
                                              session_start();
                                           }

                                           // Assuming 'AdminUserName' is stored in the session when the admin logs in
                                           $loggedInUserName = isset($_SESSION['login']) ? $_SESSION['login'] : '';
                                        ?>
                                        <label for="exampleInputEmail1">Published By</label>
                                        <input type="text" class="form-control" id="loggedInUserName" name="loggedInUserName" placeholder="User Name" value="<?php echo htmlentities($loggedInUserName); ?>" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Post Status</label>
                                        <select class="form-control" name="poststatus" id="poststatus" required>
                                           <option value="">Select Status</option>
                                           <option value="draft" <?php echo (isset($row['PostStatus']) && $row['PostStatus'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                            <option value="publish" <?php echo (isset($row['PostStatus']) && $row['PostStatus'] == 'publish') ? 'selected' : ''; ?>>Publish</option>
                                        </select>
                                    </div>
                                </div><br>
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