<?php
    session_start();
        include('includes/config.php');
        error_reporting(0);
        if(strlen($_SESSION['login'])==0)
        { 
            header('location:index.php');
        }
        else{
            if($_GET['action']=='del' && $_GET['rid'])
            {
                $id=intval($_GET['rid']);
                $query=mysqli_query($con,"update tbladvertisements set Is_Active='0' where id='$id'");
                $msg="Advertisement deleted ";
            }

            // Code for restore
            if($_GET['resid'])
            {
                $id=intval($_GET['resid']);
                $query=mysqli_query($con,"update tbladvertisements set Is_Active='1' where id='$id'");
                $msg="Advertisement restored successfully";
            }
   
            // Code for Forever deletionparmdel
            if($_GET['action']=='parmdel' && $_GET['rid'])
            {
                $id=intval($_GET['rid']);
                $query=mysqli_query($con,"delete from  tbladvertisements  where id='$id'");
                $delmsg="Advertisement deleted forever";
            } 
?>


<?php include('includes/topheader.php');?>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<!-- Left Sidebar End -->
<style>
    td.details-control {
        background: url('assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('assets/images/details_close.png') no-repeat center center;
    }
</style>


    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">                        
                        <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Manage Advertisements</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                            
                            <li class="breadcrumb-item">Advertisements</li>
                            <li class="breadcrumb-item active">Manage Advertisements</li>
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
                        <!-- <div class="header">
                            <h2>Table Tools<small>Basic example without any additional modification classes</small> </h2>
                        </div> -->
                        <div class="body">
						    <div class="table-responsive">
                                <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                       $query=mysqli_query($con,"Select id,AdTitle,AdDescription,AdImage,AdUrl,StartDate,EndDate,PostingDate,UpdationDate from  tbladvertisements where Is_Active=1");
                                       $cnt=1;
                                       while($row=mysqli_fetch_array($query))
                                       {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php echo htmlentities($row['AdTitle']);?></td>
                                        <td><?php echo htmlentities(date("d/m/Y", strtotime($row['StartDate'])));?></td>
                                        <td><?php echo htmlentities(date("d/m/Y", strtotime($row['EndDate'])));?></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="edit-advertisement.php?cid=<?php echo htmlentities($row['id']);?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <?php if ($_SESSION['utype'] == '1' || $_SESSION['utype'] == '0'): ?> 
                                                &nbsp;
                                            <a class="btn btn-danger btn-sm" href="manage-advertisements.php?rid=<?php echo htmlentities($row['id']);?>&&action=del"> 
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                       $cnt++;
                                    } ?>
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