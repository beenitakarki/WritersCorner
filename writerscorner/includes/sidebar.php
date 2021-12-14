  <div class="col-md-4">

      <!-- Search Widget -->
      <div class="card mb-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
              <form name="search" action="search.php" method="post">
                  <div class="input-group">

                      <input type="text" name="searchtitle" class="form-control" placeholder="Search for..." required>
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
                              href="category.php?catid=<?php echo htmlentities($row['id'])?>"><?php echo htmlentities($row['CategoryName']);?></a>
                      </li>
                      <?php } ?>
                  </ul>
              </div>

          </div>
      </div>
  </div>

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

  <!--Recent Post Widget-->

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