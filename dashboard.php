<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>Categories</h6>
                                <?php $query=mysqli_query($con,"select * from tblcategory where Is_Active=1");
                                   $countcat=mysqli_num_rows($query);
                                ?>
                                <span><?php echo htmlentities($countcat);?></span>
                            </div>
                            <!-- <small class="text-muted">19% compared to last week</small> -->
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#f79647" data-fill-Color="#fac091">1,4,1,3,7,1</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>Live News</h6>
                                <?php $query=mysqli_query($con,"select * from tblposts where Is_Active=1");
                                   $countposts=mysqli_num_rows($query);
                                ?>
                                <span><?php echo htmlentities($countposts);?></span>
                            </div>
                            <!-- <small class="text-muted">19% compared to last week</small> -->
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#604a7b" data-fill-Color="#a092b0">1,4,2,3,6,2</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>Subcategories</h6>
                                <?php $query=mysqli_query($con,"select * from tblsubcategory where Is_Active=1");
                                   $countsubcat=mysqli_num_rows($query);
                                ?>
                                <span><?php echo htmlentities($countsubcat);?></span>
                            </div>
                            <!-- <small class="text-muted">19% compared to last week</small> -->
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4aacc5" data-fill-Color="#92cddc">1,4,2,3,1,5</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card overflowhidden number-chart">
                        <div class="body">
                            <div class="number">
                                <h6>Views Count</h6>
                                <span>0</span>
                            </div>
                            <!-- <small class="text-muted">19% compared to last week</small> -->
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#4f81bc" data-fill-Color="#95b3d7">1,3,5,1,4,2</div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">

                <?php

                    // Fetch the last added post where IsActive = 1
                    $query = mysqli_query($con, "SELECT PostTitle, ShortDescription, PostImage FROM tblposts WHERE Is_Active = 1 ORDER BY id DESC LIMIT 1");
                    $post = mysqli_fetch_assoc($query);

                    // Check if the post exists
                    if($post) {
                       $postTitle = $post['PostTitle'];
                       $shortDescription = $post['ShortDescription'];
                       $postImage = "postimages/" . $post['PostImage']; // Assuming images are stored in 'postimages' directory
                    }
                ?>

                <div class="col-lg-8 col-md-12 left-box">
                    <div class="card single_post">
                        <div class="header">
                            <h2>Recent Posts</h2>                        
                        </div>
                        <div class="body">
                            <div class="img-postt">
                                <img class="d-block img-fluid" src="<?php echo $postImage; ?>" alt="First slide">
                            </div>
                            <h3><a href="#"><?php echo $postTitle; ?></a></h3>
                            <p><?php echo $shortDescription; ?></p>
                        </div>
                        <!-- <div class="footer">
                            <div class="actions">
                                <a href="javascript:void(0);" class="btn btn-outline-secondary">Continue Reading</a>
                            </div>
                            <ul class="stats">
                                <li><a href="javascript:void(0);">General</a></li>
                                <li><a href="javascript:void(0);" class="icon-heart">28</a></li>
                                <li><a href="javascript:void(0);" class="icon-bubbles">128</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-12 right-box">
                    <div class="card">
                        <div class="header">
                            <h2>Trending Posts</h2>                        
                        </div>
                        <div class="body widget popular-post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="single_post">
                                        <p class="m-b-0">Apple Introduces Search Ads Basic</p>
                                        <span>jun 22, 2018</span>
                                        <div class="img-post">
                                            <img src="assets/images/blog/blog-page-2.jpg" alt="Awesome Image">                                        
                                        </div>                                            
                                    </div>
                                    <div class="single_post">
                                        <p class="m-b-0">new rules, more cars, more races</p>
                                        <span>jun 8, 2018</span>
                                        <div class="img-post">
                                            <img src="assets/images/blog/blog-page-3.jpg" alt="Awesome Image">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>

<?php include('includes/footer.php');?>

<?php } ?>
