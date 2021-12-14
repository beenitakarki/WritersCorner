<?php 

session_start();
include('count.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
 $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{
  //Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
$name=$_POST['name'];
$comment=$_POST['comment'];
$postid=intval($_GET['nid']);
$st1='0';
$query=mysqli_query($con,"insert into tblcomments(postId,name,comment,status) values('$postid','$name','$comment','$st1')");

if($query){
    //$postid = isset($_GET['nid']) ? $_GET['nid'] : '';
    $msg="Comment successfully submitted. Comment will be display after Writer reviewed it. ";
  unset($_SESSION['token']);
}
else {
    $msg="Something went wrong. Please try again.";
}


}
}
}
if(isset($_POST['like']))
{		
    if(isset($_COOKIE['like'])) {

    }else{
        setCookie('like', 'yes', time()+120);
    $postid = isset($_GET['nid']) ? $_GET['nid'] : '';
    
    mysqli_query($con, "update tblposts set like_count = like_count + 1  WHERE id = $postid");
    }

}
if(isset($_POST['report']))
{		
    if(isset($_COOKIE['report'])) {

    }else{
        $report=$_POST['report'];
        setCookie('report', 'yes', time()+120);
        $postid = isset($_GET['nid']) ? $_GET['nid'] : '';   
    $sql=mysqli_query($con, "update tblposts set Report_count = Report_count + 1  WHERE id = $postid");
    if($sql){
        $msg="Post successfully reported. Writer and admin will reviewed it.";
    }else{
        $msg="Something went wrong. Please try again.";
    }

}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Writers Corner | Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- button design-->
    <style>
    .button {
        height: 40px;
        width: 350px;
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
    }
    </style>

</head>

<body>

    <!-- Navigation -->
    <?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">



        <div class="row" style="margin-top: 4%">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <!-- Blog Post -->
                <?php
$pid=intval($_GET['nid']);
 $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,view_count,tblposts.PostImage,tbluser.UserName as username, tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join tbluser on tbluser.id = tblposts.UserId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
while ($row=mysqli_fetch_array($query)) {
?>

                <div class="card mb-4">

                    <div class="card-body">

                        <?php 
                        global $msg;
                        if($msg){ ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlentities($msg);?>
                        </div>
                        <?php } ?>

                        <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
                        <p><b><i class="fa fa-eye"
                                    style="font-size:24px;"></i></b>&nbsp<?php echo htmlentities($row['view_count']);?></a>
                            |
                            <b>Posted By : </b> <?php echo htmlentities($row['username']);?></a>
                            |
                            <b>Category : </b> <a
                                href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a>
                            |
                            <b>Sub Category : </b><?php echo htmlentities($row['subcategory']);?> <b> Posted on:
                            </b><?php echo htmlentities($row['postingdate']);?>
                            <b>
                                <form method="POST">
                                    <!--Report style-->
                                    <input type="submit" name="report" value="report post" style="text-transform:uppercase; width: display: inline-block;
  padding: 10px 30px;
  font-weight: 100;
  text-decoration: none;
  border-radius: 200px;;">
                                </form>
                            </b>
                        </p>
                        <hr />



                        <img class="img-fluid rounded"
                            src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>"
                            alt="<?php echo htmlentities($row['posttitle']);?>">

                        <p class="card-text">
                            <?php 
                $pt=$row['postdetails'];
                echo  (substr($pt,0));?></p>
                    </div>
                    <div class="card-footer text-muted">

                    </div>
                </div>
                <?php } ?>






            </div>

            <!-- Sidebar Widgets Column -->
            <?php include('includes/sidebar.php');?>
        </div>
        <!-- /.row -->

        <!---Like Section --->

        <!---Comment Section --->

        <div class="row" style="margin-top: -8%">
            <div class="col-md-8">
                <div class="card my-4">
                    <!--like section -->
                    <?php
$pid=intval($_GET['nid']);
 $query=mysqli_query($con,"select * from tblposts where tblposts.id='$pid'");
while ($row=mysqli_fetch_array($query)) {
?>

                    <form method="POST">
                        <!--like input field style-->
                        <!-- <input type="submit" name="like" value="like"> -->
                        <input type="submit" class=" fa-heart" aria-hidden="true" name="like" value="like"></input>
                        <?php echo htmlentities($row['like_count']);?>
                    </form>

                    <?php }?>

                    <h5 class="card-header">Leave a Comment:</h5>
                    <div class="card-body">

                        <form name="Comment" method="post">
                            <input type="hidden" name="csrftoken"
                                value="<?php echo htmlentities($_SESSION['token']); ?>" />
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Enter your fullname"
                                    required>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Comment"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>

                <!---Comment Display Section --->

                <?php 
 $sts=1;
 $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
while ($row=mysqli_fetch_array($query)) {
?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo htmlentities($row['name']);?> <br />
                            <span style="font-size:11px;"><b>at</b>
                                <?php echo htmlentities($row['postingDate']);?></span>
                        </h5>

                        <?php echo htmlentities($row['comment']);?>
                    </div>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>


    <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<script>
$(document).ready(function() {
    $("#heart").click(function() {
        if ($("#heart").hasClass("liked")) {
            $("#heart").html('<i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>');
            $("#heart").removeClass("liked");
        } else {
            $("#heart").html('<i class="fa fa-heart fa-2x" aria-hidden="true"></i>');
            $("#heart").addClass("liked");
        }
    });
});
</script>

</html>