<?php
include("../Connection/Connection.php");
session_start();
$uid = $_SESSION['uid'];

if (isset($_GET['liid'])) {
    $countLike = 0;
    $checkLike = '';

    $selQry = "select * from tbl_likes where customer_id=" . $_SESSION['uid'] . " and post_id=" . $_GET['liid'] . "";
    $res = $conn->query($selQry);
    if ($row = $res->fetch_assoc()) {
        $sql = "delete from tbl_likes where customer_id=" . $_SESSION['uid'] . " and post_id=" . $_GET['liid'] . "";
        if($conn->query($sql))
        {
            $sellike = "SELECT COUNT(*) as l FROM tbl_likes WHERE post_id=" . $_GET['liid'] . "";
            $reslt = $conn->query($sellike);
            $like = $reslt->fetch_assoc();

            $countLike = $like['l'];

            $check = "select * from tbl_likes where post_id=" . $_GET['liid']." and customer_id=" . $_SESSION['uid'];
            $resCheck = $conn->query($check);
            if($dataCheck = $resCheck->fetch_assoc())
            $checkLike = true;
            else
            $checkLike = false;


        }
    } else {
        $sql = "insert into tbl_likes(customer_id,post_id)values('" . $_SESSION['uid'] . "','" . $_GET['liid'] . "')";
        if($conn->query($sql))
        {
            $sellike = "SELECT COUNT(*) as l FROM tbl_likes WHERE post_id=" . $_GET['liid'] . "";
            $reslt = $conn->query($sellike);
            $like = $reslt->fetch_assoc();
            $countLike = $like['l'];

            $check = "select * from tbl_likes where post_id=" . $_GET['liid']." and customer_id=" . $_SESSION['uid'];
            $resCheck = $conn->query($check);
            if($dataCheck = $resCheck->fetch_assoc())
            $checkLike = true;
            else
            $checkLike = false;

        }
    }
    $response = array(
        'countLike' => $countLike,
        'checkLike' => $checkLike
    );

    // Convert the array to JSON
    $jsonResponse = json_encode($response);

    // Echo the JSON response
    echo $jsonResponse;
   

}
?>