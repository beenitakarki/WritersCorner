<?php
// Include config file
require_once "includes/config.php";
 
// Define variables and initialize with empty values
$UserName = $EmailId = $UserPassword = $confirm_UserPassword = "";
$UserName_err = $EmailId_err = $UserPassword_err = $confirm_UserPassword_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate UserName
    if(empty(trim($_POST["UserName"]))){
        $UserName_err = "Please enter a Username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["UserName"]))){
        $UserName_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM tbluser WHERE UserName = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_UserName);
            
            // Set parameters
            $param_UserName = trim($_POST["UserName"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $UserName_err = "This UserName is already taken.";
                } else{
                    $UserName = trim($_POST["UserName"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate EmailId
    if(empty(trim($_POST["EmailId"]))){
        $EmailId_err = "Please enter your email.";     
    } elseif(!preg_match('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^',trim($_POST["EmailId"]))){
        $EmailId_err = "Invalid email";
    }else {
        $EmailId = trim($_POST["EmailId"]);
    }

    // Validate UserPassword
    if(empty(trim($_POST["UserPassword"]))){
        $UserPassword_err = "Please enter a Password.";     
    } elseif(strlen(trim($_POST["UserPassword"])) < 6){
        $UserPassword_err = "Password must have atleast 6 characters.";
    } else{
        $UserPassword = trim($_POST["UserPassword"]);
    }
    
    // Validate confirm UserPassword
    if(empty(trim($_POST["confirm_UserPassword"]))){
        $confirm_UserPassword_err = "Please confirm Password.";     
    } else{
        $confirm_UserPassword = trim($_POST["confirm_UserPassword"]);
        if(empty($UserPassword_err) && ($UserPassword != $confirm_UserPassword)){
            $confirm_UserPassword_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($UserName_err) && empty($EmailId_err) && empty($UserPassword_err) && empty($confirm_UserPassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tbluser (UserName, EmailId, UserPassword) VALUES (?, ?, ?)";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_UserName, $param_EmailId, $param_UserPassword);
            
            // Set parameters
            $param_UserName = $UserName;
            $param_EmailId = $EmailId; 
            $param_UserPassword = password_hash($UserPassword, PASSWORD_DEFAULT); // Creates a UserPassword hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($con);
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


    <script src="assets/js/modernizr.min.js"></script>

    <style>
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 360px;
        padding: 20px;
    }
    </style>

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
                                <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                            </div>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="container">
                                    <h1>Sign Up</h1>
                                    <p>Please fill in this form to create an account.</p>
                                    <hr>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <label for="UserName"><b>Username *</b></label>
                                            <input type="text" name="UserName" placeholder="Enter Username"
                                                class="form-control  <?php echo (!empty($UserName_err)) ? 'is-invalid' : ''; ?>"
                                                value="<?php echo $UserName; ?>">
                                            <span class="invalid-feedback"
                                                style="color:red;line-height: 1.8;"><?php echo  $UserName_err; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <label for="EmailId"><b>Email *</b></label>
                                            <input class="form-control" type="text" name="EmailId"
                                                placeholder="Enter Email"
                                                class="form-control  <?php echo (!empty($EmailId_err)) ? 'is-invalid' : ''; ?>"
                                                value="<?php echo $EmailId; ?> ">
                                            <span class="invalid-feedback"
                                                style="color:red;line-height: 1.8;"><?php echo $EmailId_err; ?>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <label for="psw"><b>Password *</b></label>
                                            <input type="password" name="UserPassword" placeholder="Enter Password"
                                                class="form-control  <?php echo (!empty($UserPassword_err)) ? 'is-invalid' : ''; ?>"
                                                value="<?php echo $UserPassword; ?>">
                                            <span class="invalid-feedback"
                                                style="color:red;line-height: 1.8;"><?php echo $UserPassword_err; ?>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <label for="psw-repeat"><b>Confirm Password *</b></label>
                                            <input type="password" name="confirm_UserPassword"
                                                placeholder="Enter Password"
                                                class="form-control  <?php echo (!empty($confirm_UserPassword_err)) ? 'is-invalid' : ''; ?>"
                                                value="<?php echo $confirm_UserPassword; ?>">
                                            <span class="invalid-feedback"
                                                style="color:red;line-height: 1.8;"><?php echo $confirm_UserPassword_err; ?></span>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <label>
                                                <input type="checkbox" checked="checked" name="remember"
                                                    style="margin-bottom:15px"> Remember me
                                            </label>
                                        </div>
                                    </div>


                                    <div class="clearfix">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                                        </div>
                                        <p>Already have an account? <a href="index.php">Login here</a>.</p>
                                    </div>
                                </div>
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
</body>

</html>