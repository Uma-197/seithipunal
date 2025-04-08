<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {

    // Soft delete
    if($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE tblpolls SET Is_Active = '0' WHERE id = '$id'");
        $msg = "Poll deleted successfully";
    }

    // Restore poll
    if($_GET['resid']) {
        $id = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE tblpolls SET Is_Active = '1' WHERE id = '$id'");
        $msg = "Poll restored successfully";
    }

    // Permanent delete
    if($_GET['action'] == 'parmdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM tblpolls WHERE id = '$id'");
        $delmsg = "Poll permanently deleted";
    }
?>

<?php include('includes/topheader.php');?>
<?php include('includes/leftsidebar.php');?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Polls</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Poll</li>
                        <li class="breadcrumb-item active">Manage Polls</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?php if($msg){ ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?php echo htmlentities($msg);?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php } ?>
                <?php if($delmsg){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Deleted!</strong> <?php echo htmlentities($delmsg);?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Poll Question</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Posting Date</th>
                                        <th>Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query = mysqli_query($con, "SELECT * FROM tblpolls WHERE Is_Active = 1");
                                    $cnt = 1;
                                    while($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row['PollQuestion']); ?></td>
                                        <td><?php echo htmlentities($row['StartDate']); ?></td>
                                        <td><?php echo htmlentities($row['EndDate']); ?></td>
                                        <td><?php echo htmlentities($row['PostingDate']); ?></td>
                                        <td><?php echo htmlentities($row['UpdationDate']); ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="edit-poll.php?pid=<?php echo htmlentities($row['id']); ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <?php if ($_SESSION['utype'] == '1' || $_SESSION['utype'] == '0'): ?> 
                                            &nbsp;
                                            <a class="btn btn-danger btn-sm" href="manage-polls.php?rid=<?php echo htmlentities($row['id']); ?>&action=del" onclick="return confirm('Are you sure you want to delete this poll?');">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
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
