<?php 
   session_start();
   include('includes/config.php');
   error_reporting(0);

   if(strlen($_SESSION['login'])==0) { 
      header('location:index.php');
   } else {
      if(isset($_POST['update'])) {
         $videofile = $_FILES["postvideo"]["name"];
         // Get the video extension
         $extension = substr($videofile, strlen($videofile) - 4, strlen($videofile));
         // Allowed extensions
         $allowed_extensions = array(".mp4", ".avi", ".mkv", ".mov");
         // Validation for allowed extensions
         if(!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only mp4 / avi / mkv / mov formats are allowed');</script>";
         } else {
            // Rename the video file
            $videonewfile = md5($videofile) . $extension;
            // Move the video into the directory
            move_uploaded_file($_FILES["postvideo"]["tmp_name"], "postvideos/" . $videonewfile);

            $postid = intval($_GET['pid']);
            $query = mysqli_query($con, "UPDATE tblposts SET PostVideo='$videonewfile' WHERE id='$postid'");
            
            if($query) {
               $msg = "Post Feature Video updated";
            } else {
               $error = "Something went wrong. Please try again.";    
            }
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
         url: "get_subcategory.php",
         data: 'catid=' + val,
         success: function(data) {
            $("#subcategory").html(data);
         }
      });
   }
</script>

<!-- Left Sidebar Start -->
<?php include('includes/leftsidebar.php');?>

<!-- Content -->
<div class="content-page">
   <div class="content">
      <div class="container">
         <div class="row">
            <div class="col-xs-12">
               <div class="page-title-box">
                  <h4 class="page-title">Update Video</h4>
                  <ol class="breadcrumb p-0 m-0">
                     <li><a href="#">Admin</a></li>
                     <li><a href="#">Posts</a></li>
                     <li><a href="#">Edit Posts</a></li>
                     <li class="active">Update Video</li>
                  </ol>
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-6">
               <?php if($msg){ ?>
               <div class="alert alert-success" role="alert">
                  <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
               </div>
               <?php } ?>
               <?php if($error){ ?>
               <div class="alert alert-danger" role="alert">
                  <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
               </div>
               <?php } ?>
            </div>
         </div>
         <form name="updatepost" method="post" enctype="multipart/form-data">
            <?php
               $postid = intval($_GET['pid']);
               $query = mysqli_query($con, "SELECT PostVideo, PostTitle FROM tblposts WHERE id='$postid' AND Is_Active=1");
               while($row = mysqli_fetch_array($query)) {
            ?>
            <div class="row">
               <div class="col-md-10 col-md-offset-1">
                  <div class="p-6">
                     <div class="">
                        <div class="form-group m-b-20">
                           <label for="exampleInputEmail1">Post Title</label>
                           <input type="text" class="form-control" id="posttitle" value="<?php echo htmlentities($row['PostTitle']); ?>" name="posttitle" readonly>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="card-box">
                                 <h4 class="m-b-30 m-t-0 header-title"><b>Current Post Video</b></h4>
                                 <video width="300" controls>
                                    <source src="postvideos/<?php echo htmlentities($row['PostVideo']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                 </video>
                                 <br />
                              </div>
                           </div>
                        </div>
                        <?php } ?>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="card-box">
                                 <h4 class="m-b-30 m-t-0 header-title"><b>New Feature Video</b></h4>
                                 <input type="file" class="form-control" id="postvideo" name="postvideo" required>
                              </div>
                           </div>
                        </div>
                        <button type="submit" name="update" class="btn btn-success waves-effect waves-light">Update</button>
                     </div>
                  </div> 
               </div> 
            </div>
         </form>
      </div>
   </div>
</div>
<?php include('includes/footer.php'); ?>
