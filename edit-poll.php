<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {

    $pollId = intval($_GET['pid']); // Get poll id from URL

    // Fetch current data
    $query = mysqli_query($con, "SELECT * FROM tblpolls WHERE id = '$pollId'");
    $row = mysqli_fetch_array($query);

    if(isset($_POST['update'])) {
        $question = $_POST['question'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        $today = date('Y-m-d');

        if ($startDate < $today) {
            $error = "Start date cannot be in the past.";
        } elseif ($endDate <= $startDate) {
            $error = "End date must be after start date.";
        } else {
            $update = mysqli_query($con, "UPDATE tblpolls 
                SET PollQuestion = '$question', 
                    StartDate = '$startDate', 
                    EndDate = '$endDate',
                    UpdationDate = CURRENT_TIMESTAMP 
                WHERE id = '$pollId'");

            if($update) {
                $msg = "Poll updated successfully.";
                // refresh values
                $query = mysqli_query($con, "SELECT * FROM tblpolls WHERE id = '$pollId'");
                $row = mysqli_fetch_array($query);
            } else {
                $error = "Something went wrong. Please try again.";    
            }
        }
    }
?>

<?php include('includes/topheader.php');?>
<?php include('includes/leftsidebar.php');?>

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">                        
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Edit Poll</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item">Admin</li>
                        <li class="breadcrumb-item active">Edit Poll</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?php if($msg){ ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    <strong>Success!</strong> <?php echo htmlentities($msg);?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
                <?php if($error){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                    <strong>Error!</strong> <?php echo htmlentities($error);?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
            </div>
        </div>

        <?php 
            $pollId=intval($_GET['pid']);
            $query=mysqli_query($con,"Select id,PollQuestion,StartDate,EndDate,PostingDate,UpdationDate from  tblpolls where Is_Active=1 and id='$pollId'");
            $cnt=1;
            while($row=mysqli_fetch_array($query))
            {
        ?>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form name="editpoll" method="post">
                            <div class="form-group">
                                <label class="control-label">Poll Question</label>
                                <input type="text" name="question" id="question" value="<?php echo htmlentities($row['PollQuestion']); ?>" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Poll Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="<?php echo htmlentities($row['StartDate']); ?>" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Poll End Date</label>
                                <input type="date" name="end_date" id="end_date" value="<?php echo htmlentities($row['EndDate']); ?>" class="form-control" required />
                            </div>
                            <?php } ?>
                            <button type="submit" name="update" class="btn btn-primary m-t-20">Update Poll</button>
                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
<?php } ?>
