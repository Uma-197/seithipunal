<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {

    if(isset($_POST['submit'])) {
        $question = $_POST['question'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];
        $status = 1;

        $today = date('Y-m-d');

        if ($startDate < $today) {
            $error = "Start date cannot be in the past.";
        } elseif ($endDate <= $startDate) {
            $error = "End date must be after start date.";
        } else {
            $query = mysqli_query($con, "INSERT INTO tblpolls(PollQuestion, StartDate, EndDate, Is_Active, PostingDate) 
                VALUES('$question', '$startDate', '$endDate', '$status', CURRENT_TIMESTAMP)");

            if($query) {
                $msg = "Poll created successfully.";
            } else {
                $error = "Something went wrong. Please try again.";    
            }
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
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Add Poll</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Admin</li>
                            <li class="breadcrumb-item active">Polls</li>
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
                            <form name="poll" method="post">
                                <div class="form-group">
                                    <label class="control-label">Enter Poll Question</label>
                                    <input type="text" name="question" id="question" value="" class="form-control" placeholder="Enter poll question" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Poll Start Date</label>
                                    <input type="date" name="start_date" id="start_date" value="" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Poll End Date</label>
                                    <input type="date" name="end_date" id="end_date" value="" class="form-control" required />
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary m-t-20">Create Poll</button>
                            </form>
                        </div>
                    </div>
                </div>            
            </div>

        </div>
    </div>

    
<?php include('includes/footer.php');?>

<?php } ?>