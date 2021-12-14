<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Navigation</li>
                <?php
                $uid=intval($_GET['uid']);
$sql =mysqli_query($con,"SELECT id,UserName,EmailId,UserPassword FROM tbluser where id = $uid");
$num=mysqli_fetch_array($sql);
?>

                <li class="has_sub">
                    <a href="dashboard.php?uid=<?php echo htmlentities($num['id'])?>" class="waves-effect"><i
                            class="mdi mdi-view-dashboard"></i>
                        <span> Dashboard </span> </a>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                        <span> Posts </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="add-post.php?uid=<?php echo htmlentities($num['id'])?>">Add Posts</a></li>
                        <li><a href="manage-posts.php?uid=<?php echo htmlentities($num['id'])?>">Manage Posts</a></li>
                        <li><a href="trash-posts.php?uid=<?php echo htmlentities($num['id'])?>">Trash Posts</a></li>
                    </ul>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                        <span> Comments </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="unapprove-comment.php?uid=<?php echo htmlentities($num['id'])?>">Waiting for
                                Approval </a></li>
                        <li><a href="manage-comments.php?uid=<?php echo htmlentities($num['id'])?>">Approved
                                Comments</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted"></i>
                        <span> Report </span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="reported-post.php?uid=<?php echo htmlentities($num['id'])?>"> Check your content
                            </a></li>

                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<?php ?>