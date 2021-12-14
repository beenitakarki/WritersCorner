<?php
 session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
if(isset($_POST['login']))
  {
 
    
    // Getting username/ email and password
     $uname=$_POST['username'];
    $password=$_POST['password'];
    // Fetch data from database on the basis of username/email and password
$sql =mysqli_query($con,"SELECT id,UserName,EmailId,UserPassword FROM tbluser WHERE ( id = '$uid' || UserName='$uname' || EmailId='$uname')");
 $num=mysqli_fetch_array($sql);
if($num>0)
{
$hashpassword=$num['UserPassword']; // Hashed password fething from database
//verifying Password
if (password_verify($password, $hashpassword)) {
$_SESSION['login']=$_POST['username'];
    echo "<script type='text/javascript'> document.location = 'dashboard.php?uid=$num[id]'; </script>";
  } else {
$msg = "Wrong Password";
 
  }
}
//if username or email not found in database
else{
$msg = "User not registered with us";
  }
 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="News Portal.">
    <meta name="author" content="PHPGurukul">


    <!-- App title -->
    <title>Writers Corner | Admin Panel</title>

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

    <script src="assets/js/modernizr.min.js"></script>

</head>


<body class="bg-transparent">

    <!-- HOME -->
    <section>
        <div class="container-alt">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 account-pages">
                            <div class="text-center account-logo-box">
                                <h2 class="text-uppercase">
                                    <a href="index.html" class="text-success">
                                        <!--<span><img src="assets/images/logo.png" alt="" height="56"></span>-->
                                        Writers Corner
                                    </a>
                                </h2>
                            </div>
                            <div class="account-content">
                                <form class="form-horizontal" method="post">
                                    <h4 class="text-uppercase font-bold m-b-0">Sign In as User</h4><br>
                                    <!--error msg -->
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <?php 
                                global $msg;
                                if($msg){ ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo htmlentities($msg);?>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" required="" name="username"
                                                placeholder="Username or email" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="password" name="password" required=""
                                                placeholder="Password" autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="btn-group--login text-center">
                                        <button
                                            class="btn btn-space w-md btn-bordered btn-danger waves-effect waves-light"
                                            type="submit" name="login">Log In</button></a>
                                        <a href="signup.php"
                                            class="btn w-md btn-bordered btn-danger waves-effect waves-light"
                                            name="signUp">Signup</a>
                                    </div>
                                    <div class="clearfix">
                                        <div class="form-group">
                                        </div>
                                        <p><a href="../index.php">Go Back to Home</a>.</p>

                                    </div>
                                    <div class="form-group">
                                    </div>
                                    <p style="    margin-left: 240px;
                                        font-size: 12px;"><a href="../admin/index.php">Login as Admin</a>.
                                    </p>
                            </div>
                        </div>
                        <!-- <div class="form-group account-btn text-center m-t-10">
                                        <div class="col-xs-6">
                                            <button class="btn w-md btn-bordered btn-danger waves-effect waves-light"
                                                type="submit" name="login">Log In</button>
                                        </div>
                                        <div class="form-group account-btn text-center m-l-15">
                                            <a href="signup.php" class="btn w-md btn-bordered btn-danger waves-effect waves-light" name="signUp">Signup</a>
                                        </div>    
                                    </div>-->
                        <!-- <div >
                                        <div class="col-xs-6">
                                            <button class="btn w-md btn-bordered btn-danger waves-effect waves-light"
                                                name="signUp">
                                                <a href="signup.php">Sign Up</a>
                                            </button>
                                        </div>
                                    </div> -->


                        </form>

                        <div class="clearfix"></div>

                    </div>
                </div>
                <!-- end card-box-->




            </div>
            <!-- end wrapper -->

        </div>
        </div>
        </div>
    </section>
    <!-- END HOME -->

    <script>
    var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>

</body>

</html>