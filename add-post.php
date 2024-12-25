<?php 
   session_start();
   include('includes/config.php');
   error_reporting(0);
   if(strlen($_SESSION['login'])==0)
      { 
         header('location:index.php');
      }
      else{
   
         // For adding post  
         if(isset($_POST['submit']))
         {
            $optionsArray = isset($_POST['options']) ? $_POST['options'] : []; // Fetch the selected options
            $options = implode(',', $optionsArray); // Convert array to comma-separated string

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
            $postedby=$_POST['loggedInUserName'];
            $poststatus = $_POST['poststatus'];
            $arr = explode(" ",$posttitle);
            $url=implode("-",$arr);
            $imgfile=$_FILES["postimage"]["name"];
            $videofile=$_FILES["postvideo"]["name"];

            // get the image extension
            $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));

            // Get the video extension
            $video_extension = substr($videofile, strlen($videofile) - 4, strlen($videofile));

            // allowed extensions
            $allowed_extensions = array(".jpg","jpeg",".png",".gif");
            $allowed_video_extensions = array(".mp4", ".avi", ".mkv", ".mov");

            // Validation for allowed extensions .in_array() function searches an array for a specific value.
            if(!in_array($extension,$allowed_extensions))
            {
               echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            }
            elseif ($videofile && !in_array($video_extension, $allowed_video_extensions)) {
               // Validate video file only if it exists
               echo "<script>alert('Invalid video format. Only mp4 / avi / mkv / mov formats are allowed');</script>";
            }
            else
            {
               //rename the image file
               $imgnewfile=md5($imgfile).$extension;

               // Rename the video file (if uploaded)
               $videonewfile = $videofile ? md5($videofile) . $video_extension : null;

               // Code for move image into directory
               move_uploaded_file($_FILES["postimage"]["tmp_name"],"postimages/".$imgnewfile);
               if ($videofile) {
                  move_uploaded_file($_FILES["postvideo"]["tmp_name"], "postvideos/" . $videonewfile);
               }
   
               $status=1;

               $query=mysqli_query($con,"insert into tblposts
                  (PostTitle,TamilTitle,CategoryId,SubCategoryId,TagId,HashTag,District,LatestNews,PostDetails,ShortDescription,PostUrl,Is_Active,PostImage,PostVideo,postedBy,PostStatus,Options) 
                  values
                  ('$posttitle','$tamiltitle','$catid','$subcatid','$tagid','$htag','$district','$latestnews','$postdetails','$shortdescription','$url','$status','$imgnewfile','$videonewfile','$postedby','$poststatus','$options')");

               if($query)
               {
                  $msg="Post successfully added ";
               }
               else{
                  $error="Something went wrong . Please try again.";    
               }
            }
         }
      
?>
      
<!-- Top Bar Start -->
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Post</h2>
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
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label class="control-label">Post Title</label>                                   
                                        <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter Title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">Post Title(Tamil)</label>                                   
                                        <input type="text" class="form-control" id="tamiltitle" name="tamiltitle" placeholder="Enter Tamil Title" required>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Category</label>
                                        <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                                            <option value="">Select Category </option>
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
                                        <select class="form-control" name="subcategory" id="subcategory" required></select> 
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Main Tag</label>
                                        <select class="form-control" name="maintag" id="maintag" required>
                                            <option value="">Select Tag </option>
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
                                            <option value="htag">Hashtag</option>
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">District</label>
                                        <select class="form-control" name="district" id="district" required>
                                            <option value="">Select District </option>
                                            <option value="1">காஞ்சிபுரம்</option>
                                            <option value="2">திருவள்ளூர்</option>
                                            <option value="3">வேலூர்</option>
                                            <option value="4">திருவண்ணாமலை</option>
                                            <option value="5">விழுப்புரம்</option>
                                            <option value="6">சேலம்</option>
                                            <option value="7">நாமக்கல்</option>
                                            <option value="8">தர்மபுரி</option>
                                            <option value="9">கிருஷ்ணகிரி</option>
                                            <option value="10">ஈரோடு</option>
                                            <option value="11">நீலகிரி</option>
                                            <option value="12">திருச்சி</option>
                                            <option value="13">கரூர்</option>
                                            <option value="14">பெரம்பலூர்</option>
                                            <option value="15">அரியலூர்</option>
                                            <option value="16">புதுக்கோட்டை</option>
                                            <option value="17">தஞ்சாவூர்</option>
                                            <option value="18">திருவாரூர்</option>
                                            <option value="19">நாகப்பட்டினம்</option>
                                            <option value="20">திண்டுக்கல்</option>
                                            <option value="21">தேனி</option>
                                            <option value="22">ராமநாதபுரம்</option>
                                            <option value="23">சிவகங்கை</option>
                                            <option value="24">விருதுநகர்</option>
                                            <option value="25">திருநெல்வேலி</option>
                                            <option value="26">தூத்துக்குடி</option>
                                            <option value="27">கன்னியாகுமரி</option>
                                            <option value="28">திருப்பூர்</option>
                                            <option value="29">கடலூர்</option>
                                            <option value="30">மதுரை</option>
                                            <option value="31"> சென்னை</option>
                                            <option value="32">கோவை</option>
                                            <option value="33">செங்கல்பட்டு</option>
                                            <option value="34">திருப்பத்தூர்</option>
                                            <option value="35">இராணிப்பேட்டை</option>
                                            <option value="36">கள்ளக்குறிச்சி</option>
                                            <option value="37">தென்காசி</option>
                                            <option value="38">மயிலாடுதுறை</option>
                                        </select> 
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Options</label><br>
                                            <label>
                                                <input id="IsVideo" type="checkbox" name="options[]" value="IsVideo"> 
                                                <label for="IsVideo">Is Video?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsGallery" type="checkbox" name="options[]" value="IsGallery"> <label for="IsGallery">Is Gallery?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsFlash" type="checkbox" name="options[]" value="IsFlash"> <label for="IsFlash">Is flash news?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsScroll" type="checkbox" name="options[]" value="IsScroll"> <label for="IsScroll">Is scroller news?</label>
                                            </label>
                                                
                                            <label>
                                                <input id="IsRecent" type="checkbox" name="options[]" value="IsRecent" checked="checked"> <label for="IsRecent">Is recent news?</label>
                                            </label>
                                    </div>
                                </div><br>
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
                                        <input type="file" class="form-control" id="postimage" name="postimage"  required>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="m-b-30 m-t-0 header-title"><b>Feature Video</b></h4>
                                        <input type="file" class="form-control" id="postvideo" name="postvideo">
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label class="control-label">Full Description</label>
                                    <textarea class="summernote" name="postdescription" id="summernote" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Short Description(Full News in Tamil Maximum 220 Characters)</label>
                                    <textarea class="summernote" name="shortdescription" id="summernote2" maxlength="220" required></textarea>
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
                                           <option value="draft">Draft</option>
                                           <option value="publish">Publish</option>
                                        </select>
                                    </div>
                                </div><br>

                                <button type="button" class="btn btn-secondary m-t-20" data-toggle="modal" data-target="#previewModal">Preview</button>

                                <button type="submit" name="submit" class="btn btn-primary   m-t-20">Add Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Title: <span id="previewTitle"></span></h4>
        <h5>Tamil Title: <span id="previewTamilTitle"></span></h5>
        <p><strong>Category:</strong> <span id="previewCategory"></span></p>
        <p><strong>Sub Category:</strong> <span id="previewSubCategory"></span></p>
        <p><strong>Tags:</strong> <span id="previewTags"></span></p>
        <p><strong>Hashtags:</strong> <span id="previewHashtags"></span></p>
        <p><strong>District:</strong> <span id="previewDistrict"></span></p>
        <p><strong>Post Status:</strong> <span id="previewStatus"></span></p>
        <p><strong>Latest News:</strong> <span id="previewLatestNews"></span></p>
        <p><strong>Description:</strong> <span id="previewDescription"></span></p>
        <p><strong>Short Description:</strong> <span id="previewShortDescription"></span></p>
        <img src="" id="previewImage" alt="Feature Image" style="max-width: 100%; margin-top: 20px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Function to handle Preview button click
  document.querySelector('[data-toggle="modal"]').addEventListener('click', function() {
    // Get form values
    var postTitle = document.getElementById('posttitle').value;
    var tamilTitle = document.getElementById('tamiltitle').value;
    var category = document.getElementById('category').options[document.getElementById('category').selectedIndex].text;
    var subCategory = document.getElementById('subcategory').options[document.getElementById('subcategory').selectedIndex]?.text || '';
    var tags = document.getElementById('maintag').options[document.getElementById('maintag').selectedIndex].text;
    var hashtags = document.getElementById('hashtag').value;
    var district = document.getElementById('district').options[document.getElementById('district').selectedIndex].text;
    var status = document.getElementById('poststatus').options[document.getElementById('poststatus').selectedIndex].text;
    var latestNews = document.getElementById('latestnews').value;
    var description = document.getElementById('summernote').value;
    var shortDescription = document.getElementById('summernote2').value;
    var imageSrc = document.getElementById('postimage').files[0] ? URL.createObjectURL(document.getElementById('postimage').files[0]) : '';

    // Update modal content
    document.getElementById('previewTitle').textContent = postTitle;
    document.getElementById('previewTamilTitle').textContent = tamilTitle;
    document.getElementById('previewCategory').textContent = category;
    document.getElementById('previewSubCategory').textContent = subCategory;
    document.getElementById('previewTags').textContent = tags;
    document.getElementById('previewHashtags').textContent = hashtags;
    document.getElementById('previewDistrict').textContent = district;
    document.getElementById('previewStatus').textContent = status;
    document.getElementById('previewLatestNews').textContent = latestNews;
    document.getElementById('previewDescription').textContent = description;
    document.getElementById('previewShortDescription').textContent = shortDescription;
    document.getElementById('previewImage').src = imageSrc;
  });
</script>

    
<?php include('includes/footer.php');?>

<?php } ?>