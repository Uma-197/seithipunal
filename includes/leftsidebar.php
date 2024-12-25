
<div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <!-- <div class="user-account">
                <img src="assets/images/user.png" class="rounded-circle user-photo" alt="User Profile Picture">
                <div class="dropdown">
                    <?php
                        session_start();

                        // Get the logged-in user's name from the session (if available)
                        $userName = isset($_SESSION['login']) ? $_SESSION['login'] : 'Guest'; // Default to 'Guest' if not logged in
                    ?>
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="user-name" data-toggle="dropdown"><strong><?php echo htmlentities($userName); ?></strong></a>
                </div>
                <hr>
            </div> -->
                
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu">
                            <?php 
                                $currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
                            ?>                            
                            <li class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="icon-home"></i> <span>Dashboard</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>"><a href="dashboard.php">Dashboard</a></li>
                                </ul>
                            </li>

                            <?php
                                // Assuming utype is stored in session during login
                                if (isset($_SESSION['utype']) && $_SESSION['utype'] == 1) { 
                            ?>
                            <li class="<?php echo in_array($currentPage, ['add-subadmins.php', 'edit-subadmin.php', 'manage-subadmins.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="fa fa-users"></i> <span>Users</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'add-subadmins.php') ? 'active' : ''; ?>"><a href="add-subadmins.php">Add User</a> </li>
                                    <li class="<?php echo ($currentPage == 'manage-subadmins.php') ? 'active' : ''; ?>"><a href="manage-subadmins.php">Manage Users</a> </li>
                                </ul>
                            </li>
                            <?php } ?>

                            <li class="<?php echo in_array($currentPage, ['add-category.php', 'edit-category.php', 'manage-category.php', 'add-subcategory.php', 'edit-subcategory.php', 'manage-subcategory.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="fa fa-list"></i> <span>Categories</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'add-category.php') ? 'active' : ''; ?>"><a href="add-category.php">Add Category</a></li>
                                    <li class="<?php echo ($currentPage == 'manage-category.php') ? 'active' : ''; ?>"><a href="manage-category.php">Manage Category</a></li>
                                    <li class="<?php echo ($currentPage == 'add-subcategory.php') ? 'active' : ''; ?>"><a href="add-subcategory.php">Add Sub Category</a></li>
                                    <li class="<?php echo ($currentPage == 'manage-subcategory.php') ? 'active' : ''; ?>"><a href="manage-subcategory.php">Manage Sub Category</a></li>
                                </ul>
                            </li>

                            <li class="<?php echo in_array($currentPage, ['add-tag.php', 'edit-tag.php', 'manage-tags.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="icon-tag"></i> <span>Tags</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'add-tag.php') ? 'active' : ''; ?>"><a href="add-tag.php">Add Tag</a> </li>
                                    <li class="<?php echo ($currentPage == 'manage-tags.php') ? 'active' : ''; ?>"><a href="manage-tags.php">Manage Tags</a> </li>
                                </ul>
                            </li>

                            <li class="<?php echo in_array($currentPage, ['add-post.php', 'edit-post.php', 'manage-posts.php', 'trash-posts.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="icon-globe"></i> <span>News Posts</span></a>
                                <ul>                                    
                                    <li class="<?php echo ($currentPage == 'add-post.php') ? 'active' : ''; ?>"><a href="add-post.php">Add News Posts</a></li>
                                    <li class="<?php echo ($currentPage == 'manage-posts.php') ? 'active' : ''; ?>"><a href="manage-posts.php">Manage News Posts</a></li>
                                    <?php if ($_SESSION['utype'] == 1 || $_SESSION['utype'] == 0) { ?>
                                    <li class="<?php echo ($currentPage == 'trash-posts.php') ? 'active' : ''; ?>"><a href="trash-posts.php">Trash News Posts</a></li>
                                    <?php } ?>
                                </ul>
                            </li>

                            <li class="<?php echo in_array($currentPage, ['home.php', 'aboutus.php', 'contactus.php', 'terms.php', 'privacy.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);vvvv" class="has-arrow"><i class="icon-docs"></i> <span>Pages</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'home.php') ? 'active' : ''; ?>"><a href="home.php">Home</a> </li>
                                    <li class="<?php echo ($currentPage == 'aboutus.php') ? 'active' : ''; ?>"><a href="aboutus.php">About Us</a> </li>
                                    <li class="<?php echo ($currentPage == 'contactus.php') ? 'active' : ''; ?>"><a href="contactus.php">Contact Us</a> </li>
                                    <li class="<?php echo ($currentPage == 'terms.php') ? 'active' : ''; ?>"><a href="terms.php">Terms</a> </li>
                                    <li class="<?php echo ($currentPage == 'privacy.php') ? 'active' : ''; ?>"><a href="privacy.php">Privacy</a> </li>
                                </ul>
                            </li>

                            <li class="<?php echo ($currentPage == 'manage-messages.php') ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="fa fa-weixin"></i> <span>Enquiry Messages</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'manage-messages.php') ? 'active' : ''; ?>"><a href="manage-messages.php">Messages</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="has-arrow"><i class="icon-folder"></i> <span>Media</span></a>
                                <ul>                                    
                                    <li class="<?php echo ($currentPage == '') ? 'active' : ''; ?>"><a href="#">Media</a></li>
                                    <li class="<?php echo ($currentPage == '') ? 'active' : ''; ?>"><a href="#">Images</a></li>
                                </ul>
                            </li>

                            <li class="<?php echo in_array($currentPage, ['manage-reports.php', 'google-reports.php']) ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="fa fa-bar-chart-o"></i> <span>Reports</span></a>
                                <ul>                                    
                                    <li class="<?php echo ($currentPage == 'manage-reports.php') ? 'active' : ''; ?>"><a href="manage-reports.php">User Reports</a></li>
                                    <li class="<?php echo ($currentPage == '') ? 'active' : ''; ?>"><a href="#">Google Reports</a></li>
                                </ul>
                            </li>

                            <li class="<?php echo ($currentPage == 'user-profile.php') ? 'active' : ''; ?>">
                                <a href="javascript:void(0);" class="has-arrow"><i class="fa fa-user"></i> <span>User Profile</span></a>
                                <ul>
                                    <li class="<?php echo ($currentPage == 'user-profile.php') ? 'active' : ''; ?>"><a href="user-profile.php">Profile</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>                
            </div>          
        </div>
    </div>