<?php 
session_start();
include('../includes/config.php');
    
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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="../css/modern-business.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <?php include('../includes/trendings-header.php');?>
    <div id="trending-section">
        <div class="trending-post">
            <h1>
                Trending Posts
            </h1>

        </div>
    </div>

    <!-- Page Content -->
    <div class="container">



        <div class="row" style="margin-top: 4%">

            <!--title-->
            <!-- <h1 style="color:#0C6980;font-size:3em;font-weight: bolder">Top Trending Posts</h1><br> -->
            <!-- Blog Entries Column -->
            <div class="col-md-8">


                <!-- Blog Post -->
                <?php 
     if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 8;
        $offset = ($pageno-1) * $no_of_records_per_page;


        $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
        $result = mysqli_query($con,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        
        
$query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,view_count,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.view_count desc  LIMIT $offset, $no_of_records_per_page");
while ($row=mysqli_fetch_array($query)) {
    ?>

                <div class="card mb-4">
                    <img class="card-img-top" src="../admin/postimages/<?php echo htmlentities($row['PostImage']);?>"
                        alt="<?php echo htmlentities($row['posttitle']);?>">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?>
                        </h2>
                        <p><b><i class="fa fa-eye"
                                    style="font-size:24px;"></i></b>&nbsp<?php echo htmlentities($row['view_count']);?></a>
                            |
                            <b>Category : </b> <a
                                href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a>
                        </p>


                        <a href="../news-details.php?nid=<?php echo htmlentities($row['pid'])?>"
                            class="btn btn-primary">Read
                            More &rarr;</a>


                    </div>
                    <div class="card-footer text-muted">
                        Posted on <?php echo htmlentities($row['postingdate']);?>

                    </div>
                </div>
                <?php } ?>




                <!-- Pagination -->


                <ul class="pagination justify-content-center mb-4">
                    <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
                        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"
                            class="page-link">Prev</a>
                    </li>
                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
                        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> "
                            class="page-link">Next</a>
                    </li>
                    <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                </ul>

            </div>

            <!-- Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Search Widget -->
                <div class="card mb-4">
                    <h5 class="card-header">Search</h5>
                    <div class="card-body">
                        <form name="search" action="search.php" method="post">
                            <div class="input-group">

                                <input type="text" name="searchtitle" class="form-control" placeholder="Search for..."
                                    required>
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="submit">Go!</button>
                                </span>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Categories</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled mb-0">
                                <?php $query=mysqli_query($con,"select id,CategoryName from tblcategory");
while($row=mysqli_fetch_array($query))
{
?>

                                <li>
                                    <a
                                        href="trending-category.php?catid=<?php echo htmlentities($row['id'])?>"><?php echo htmlentities($row['CategoryName']);?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->

            <!-- Most Likes Widget -->
            <div class="card my-4">
                <h5 class="card-header">Our Top Most Liked Posts</h5>
                <div class="card-body" style="margin-left: -35px;">
                    <ul class="mb-0">
                        <?php
$query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId order by tblposts.like_count desc limit 5");
while ($row=mysqli_fetch_array($query)) {

?>

                        <li style="list-style: none;">
                            <a
                                href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>"><?php echo htmlentities($row['posttitle']);?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="card my-4">
                <h5 class="card-header">Recent Posts</h5>
                <div class="card-body" style="margin-left: -35px;">
                    <ul class="mb-0">
                        <?php
$query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId limit 8");
while ($row=mysqli_fetch_array($query)) {

?>

                        <li style="list-style: none;">
                            <a
                                href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>"><?php echo htmlentities($row['posttitle']);?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php include('../includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    </head>
</body>


</html>