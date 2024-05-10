<?php
include("../Connection/Connection.php");
session_start();
$uid = $_SESSION['uid'];

if (isset($_GET['coid'])) {
    $countcomment = 0;
    $commentsection = '';


    $comment = $_GET['msg'];
    $postid = $_GET['coid'];
    $sql = "insert into tbl_comments (post_id,customer_id,comment_text,created_on) values('" . $postid . "','" . $uid . "','" . $comment . "',current_timestamp())";
    $conn->query($sql);
}

$selcomment = "SELECT COUNT(*) as c FROM tbl_comments WHERE post_id=" . $postid . "";
$rst = $conn->query($selcomment);
$comm = $rst->fetch_assoc();
$countcomment = $comm['c'];
echo $countcomment;





?>