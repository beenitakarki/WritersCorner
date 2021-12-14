<?php 
    include('includes/config.php');
    if(isset($_COOKIE['reader'])) {

    }else{
        setCookie('reader', 'yes', time()+180);
    $postid = isset($_GET['nid']) ? $_GET['nid'] : '';
    mysqli_query($con, "update tblposts set view_count = view_count + 1  WHERE id = $postid");
    }

?>