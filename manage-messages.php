<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    // Mark as Read
    if ($_GET['readid']) {
        $id = intval($_GET['readid']);
        $query = mysqli_query($con, "UPDATE tblmessages SET Status='1' WHERE id='$id'");
        $msg = "Message marked as Read.";
    }

    // Mark as Unread
    if ($_GET['unreadid']) {
        $id = intval($_GET['unreadid']);
        $query = mysqli_query($con, "UPDATE tblmessages SET Status='0' WHERE id='$id'");
        $msg = "Message marked as Unread.";
    }

    // Delete Message
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE tblmessages SET Is_Active='0' WHERE id='$id'");
        $delmsg = "Message Deleted.";
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Messages</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Messages</li>
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
                    <?php if($delmsg){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                        <strong>Well done!</strong> <?php echo htmlentities($delmsg);?>
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
                        <!-- <div class="header">
                            <h2>Messages</h2>
                        </div> -->
                        <div class="body">
                            <button type="button" class="btn mb-1 btn-simple btn-sm btn-default btn-filter" data-target="all">All</button>
                            <button type="button" class="btn mb-1 btn-simple btn-sm btn-success btn-filter" data-target="approved">Read</button>
                            <button type="button" class="btn mb-1 btn-simple btn-sm btn-danger btn-filter" data-target="blocked">Un Read</button>
                            <div class="table-responsive m-t-20">
                                <table class="table table-filter table-hover m-b-0">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Purpose</th>
                                        <th>Phone Number</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Posting Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>                                
                                    <tbody>
                                        <?php 
                                            $query = mysqli_query(
                                                $con,
                                                "SELECT id, FullName, EmailId, postingDate, Comment, Purpose, PhoneNumber, Status FROM tblmessages WHERE Is_Active = 1"
                                            );
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                        ?>

                                        <tr data-status="<?php echo $row['Status'] == '1' ? 'approved' : 'blocked'; ?>">
                                            <td><?php echo htmlentities($cnt); ?></td>
                                            <td><?php echo htmlentities($row['FullName']); ?></td>
                                            <td><?php echo htmlentities($row['EmailId']); ?></td>
                                            <td><?php echo htmlentities($row['Purpose']); ?></td>
                                            <td><?php echo htmlentities($row['PhoneNumber']); ?></td>
                                            <td><?php echo htmlentities($row['Comment']); ?></td>
                                            <td><span class="badge badge-<?php echo $row['Status'] == '1' ? 'success' : 'danger'; ?>">
                                                    <?php echo $row['Status'] == '1' ? 'Read' : 'Un read'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlentities($row['postingDate']); ?></td>
                                            <td width="150px">
                                                <?php if ($row['Status'] == '0') { ?>
                                                    <a href="manage-messages.php?readid=<?php echo htmlentities($row['id']); ?>" class="btn btn-success btn-sm" title="Mark as Read">
                                                        <i class="ion-checkmark"></i> Read
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="manage-messages.php?unreadid=<?php echo htmlentities($row['id']); ?>" class="btn btn-warning btn-sm" title="Mark as Unread">
                                                        <i class="ion-arrow-return-left"></i> Unread
                                                    </a>
                                                <?php } ?>
                                                <a href="manage-messages.php?rid=<?php echo htmlentities($row['id']); ?>&action=del" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fa fa-trash-o"></i> Delete
                                                </a>
                                            </td>
                                        </tr>

                                        <?php 
                                            $cnt++;
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
<?php include('includes/footer.php');?>

<?php } ?>
