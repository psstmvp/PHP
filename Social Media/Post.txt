<?php
ob_start();
include('Head.php');
include("../Assets/Connection/Connection.php");
$uid = $_SESSION['uid'];
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <!-- MDB icon -->
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="../Assets/CssPages/bootstrap-news-feed.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css>">
</head>
<meta http-equiv=" Content-Type" content="text/html; charset=utf-8" />
<title>feeds</title>
<style>
  .center {
    margin-left: auto;
    margin-right: auto;
  }

  .scroll-container {
    height: 200px;
    overflow: auto;
  }

  .scroll-container::-webkit-scrollbar {
    width: 0.5em;
    /* Adjust to your preference */
  }

  .scroll-container::-webkit-scrollbar-thumb {
    background-color: transparent;
    /* Hides the thumb */
  }

  .scroll-container::-webkit-scrollbar-track {
    background-color: transparent;
    /* Hides the track */
  }
</style>
</head>

<body>
  <div style="margin-top:50px">

  <?php
  // declare variable counter
  $counter = 0;
  $selqry = "select * from tbl_post where report_status=0 or report_status=3  ORDER BY created_on DESC";
  $res = $conn->query($selqry);
  while ($row = $res->fetch_assoc()) {
    //increment variable counter
    $counter++;

    ?>
    <table style="border:1px solid black;margin-left:auto;margin-right:auto;">
      <div>
        <!--Section: Newsfeed-->
        <section style="display: flex; justify-content:center;">
          <div class="card" style="width:60%;padding:20px">
            <div class="card-body">
              <!-- Data -->

              <?php

$seltime = "SELECT created_on,
CASE
WHEN TIMESTAMPDIFF(SECOND, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(SECOND, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' seconds ago')
WHEN TIMESTAMPDIFF(MINUTE, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' minutes ago')
WHEN TIMESTAMPDIFF(HOUR, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 24 THEN CONCAT(TIMESTAMPDIFF(HOUR, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' hours ago')
WHEN TIMESTAMPDIFF(DAY, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 7 THEN CONCAT(TIMESTAMPDIFF(DAY, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' days ago')
WHEN TIMESTAMPDIFF(WEEK, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 4 THEN CONCAT(TIMESTAMPDIFF(WEEK, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' weeks ago')
WHEN TIMESTAMPDIFF(MONTH, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()) < 12 THEN CONCAT(TIMESTAMPDIFF(MONTH, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' months ago')
ELSE CONCAT(TIMESTAMPDIFF(YEAR, STR_TO_DATE(created_on, '%Y-%m-%d %H:%i:%s'), NOW()), ' years ago')
END AS time_elapsed
FROM tbl_post
WHERE post_id = " . $row['post_id'] . "";


$restime = $conn->query($seltime);
$rowTime = $restime->fetch_assoc();
$timeElapsed = $rowTime['time_elapsed'];
?>

<div style="text-align: right;">
  <span style="color: gray; text-align: right;">
    <?php echo $timeElapsed ?>
  </span>
</div>

              <div class="d-flex mb-3">
                <?php
                $sel = "select * from tbl_seller_bio where seller_id='" . $row['seller_id'] . "'";
                $result = $conn->query($sel);
                $srow = $result->fetch_assoc()
                  ?>
                <a href="EachSeller.php?siid=<?php echo $srow['seller_bio_id'] ?>" style="text-decoration:none"><img
                    src="../Assets/File/Seller/SellerBio/<?php echo $srow['sell_profilepic']; ?>" width="50px"
                    height="50px" class="border rounded-circle me-2"></a>


                <div>

                  <strong>
                    <?php echo $srow['bio_nickname']; ?>
                  </strong>

                </div>
              </div>


              <!-- caption -->
              <div>
                <?php echo $row['post_caption'] ?>
              </div>
            </div>
            <!-- Media -->
            <div>
              <?Php
              if ($row['post_type'] === 'image') {
                ?>
                <center><img src="../Assets/File/Seller/Posts/<?php echo $row['post_media'] ?>" alt="Post Image" width="70%"
                    style="object-fit: contain; min-height:400px; "></center>
                <?php
              } elseif ($row['post_type'] === 'video') { ?>
                <center><video controls width="70%" height="70%">
                    <source src="../Assets/File/Seller/Posts/<?php echo $row['post_media'] ?>" type="video/mp4">Your browser
                    does not support the video tag
                  </video></center>

              <?php } ?>
            </div>
            <div>
              <?php echo $row['post_content'] ?><br>
              <?php if($row['product_id']!=0) {?>
              <a href="ViewProducts.php?spid=<?php echo $row['product_id']?>"> See this product..</a>
              <?php }?>
            </div>
            <!-- Media -->
            <!-- Interactions -->
            <div class="card-body">
              <!-- Reactions -->
              <div class="d-flex justify-content-between mb-3">
                <div>

                  <!-- change like icon using query and ajax -->

                  <?php
                  $check = "select * from tbl_likes where post_id=" . $row['post_id'] . " and customer_id=" . $_SESSION['uid'];
                  $resCheck = $conn->query($check);
                  ?>
                  <!-- make id uniq comment with counter -->
                  <span id="checkLikeTrue<?php echo $counter; ?>">
                    <i id="checkLikeTrue" class="fas fa-heart 
                  <?php
                  if ($resCheck->fetch_assoc())
                    echo "text-danger";
                  else
                    echo "";
                  ?> " style="font-size: 20px;"></i>
                  </span>
                  <!-- end change like icon using query and ajax -->

                  <?php

                  $sellike = "SELECT COUNT(*) as l FROM tbl_likes WHERE post_id=" . $row['post_id'] . "";
                  $reslt = $conn->query($sellike);
                  $like = $reslt->fetch_assoc();
                  ?>
                  <span id="like<?php echo $counter; ?>" class="text-muted">
                    <?php echo $like['l'] ?>
                  </span><span class="text-muted"> likes</span>
                </div>
                <?php
                $selcomment = "SELECT COUNT(*) as c FROM tbl_comments WHERE post_id=" . $row['post_id'] . "";
                $rst = $conn->query($selcomment);
                $comm = $rst->fetch_assoc();
                ?>
                <div>
                  <span id="comcount<?php echo $counter; ?>" class="text-muted">
                    <?php echo $comm['c'] ?>
                  </span> <span class="text-muted">comments </span>
                </div>
              </div>
              <!-- Reactions -->

              <!-- Buttons -->
              <div class="d-flex justify-content-between text-center border-top border-bottom mb-4">


                <button type="button" value="<?php echo $row['post_id'] ?>" style="text-decoration:none"
                  class="btn btn-link btn-lg" data-mdb-ripple-color="dark"
                  onClick="likeUnlike(this.value,<?php echo $counter; ?>)">
                  <i class="fas fa-heart " style="font-size: 15px;"> </i>
                  Like</button>
                <!-- make id uniq comment with counter -->

                <button type="button" class="btn btn-link btn-lg" data-mdb-ripple-color="dark"
                  onclick="toggleComment(<?php echo $counter; ?>)">

                  <i class="fas fa-comment-alt me-2"></i>Comment
                </button>

                <button type="button" class="btn btn-link btn-lg" data-bs-toggle="modal"
                  data-bs-target="#exampleModal<?php echo $counter; ?>">
                  <i class="fa fa-exclamation-circle me-2" style="font-size: 20px;"> </i>report</button>
              </div>
              <!-- Buttons -->

              <!-- Comments -->

              <!-- Input -->
              <!-- make id uniq comment with counter -->
              <div id="comment<?php echo $counter; ?>" style="display:none">
                <div id="subcomment<?php echo $counter; ?>">
                  <div>
                    <div class="d-flex mb-3">
                      <?php
                      $selcus = "SELECT * FROM tbl_customer where customer_id=" . $uid . "";
                      $rescus = $conn->query($selcus);
                      $rowcus = $rescus->fetch_assoc();
                      ?>
                      <img src="../Assets/File/Customer/<?php echo $rowcus['cus_photo']; ?>"
                        class="border rounded-circle me-2" alt="Avatar" style="height: 40px" />
                      <div class="form-outline w-100" align="right">
                        <textarea class="form-control" required id="textAreaExample<?php echo $counter; ?>" name="comment"
                          rows="2"></textarea>
                        <!-- <input type="hidden" name="postid" value="<?php //echo $row['post_id'] ?>"> -->
                        <label class="form-label" for="textAreaExample">Write a comment</label>
                        <button type="button" name="btncomment" value="<?php echo $row['post_id'] ?>"
                          onclick="postComment(this.value,<?php echo $counter; ?>)" class="btn btn-link btn-lg"
                          data-mdb-ripple-color="dark">post</button>
                      </div>
                    </div>



                    <!-- Input -->

                    <!-- existing comments -->
                    <div class="scroll-container" id="viewComment<?php echo $counter; ?>">
                      <div>
                        <?php
                        $postId = $row['post_id'];
                        $selcom = "select * from tbl_comments where post_id=" . $row['post_id'] . "";
                        $rescom = $conn->query($selcom);
                        while ($rowcom = $rescom->fetch_assoc()) {
                          $cuscom = "select *from tbl_customer where customer_id=" . $rowcom['customer_id'] . "";
                          $recuscom = $conn->query($cuscom);
                          $comrow = $recuscom->fetch_assoc();

                          ?>
                          <div class="d-flex mb-3">
                            <img src="../Assets/File/Customer/<?php echo $comrow['cus_photo']; ?>"
                              class="border rounded-circle me-2" alt="Avatar" style="height: 40px" />
                            <div>
                              <div class="bg-light rounded-3 px-3 py-1">
                                <strong class="text-dark mb-0">
                                  <?php echo $comrow['cus_name']; ?>
                                </strong>
                                <small class="text-muted d-block">
                                  <?php echo $rowcom['comment_text']; ?>
                                </small>
                                <?php
                                if ($rowcom['customer_id'] == $uid) {

                                  ?>

                                  <button value="<?php echo $rowcom['comment_id'] ?>" style="text-decoration:none"
                                    class="btn btn-link btn-lg" data-mdb-ripple-color="dark"
                                    onclick="deleteComment(this.value,<?php echo $postId ?>,<?php echo $counter; ?>)">

                                    <i class="fa fa-trash me-2" style="font-size: 10 px;"></i> delete</button>
                                  <?php
                                }
                                ?>

                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Interactions -->
            </div>


        </section>
        <div class="modal fade" style="position: relative;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); margin-bottom: 20px;" id="exampleModal<?php echo $counter; ?>" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">why are you reporting this post:</label>
                    <input type=hidden value="<?php echo $row['post_id'] ?>">
                    <textarea class="form-control" required id="message-text<?php echo $counter; ?>" ></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                  value="<?php echo $row['post_id'] ?>"
                  onclick="reportPost(this.value,<?php echo $counter; ?>)">Report</button>
              </div>
            </div>
          </div>
        </div>
      </div>



    </table><br>

    <?php
  }
  ?>

  <!--Section: Newsfeed-->
  </div>

</body>
<script src="../Assets/JQ/jQuery.js "></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleComment(postNumber) {
    var viewmoreDiv = document.getElementById('comment' + postNumber);
    if (viewmoreDiv.style.display === 'none') {
      viewmoreDiv.style.display = 'block';
    } else {
      viewmoreDiv.style.display = 'none';
    }
  }


  function likeUnlike(lid, postNumber) {
    //get couter in postNumber
    $.ajax({
      url: "../Assets/AjaxPages/AjaxLike.php?liid=" + lid,
      success: function (response) {
        // Parse the JSON response
        var data = JSON.parse(response);

        // Access the values
        var countLike = data.countLike;
        var checkLike = data.checkLike;
        if (checkLike === true) {
          //add for uniq postNumber

          $("#checkLikeTrue" + postNumber).html('<i class="fas fa-heart text-danger" style="font-size: 20px;"></i>');
        } else {
          $("#checkLikeTrue" + postNumber).html('<i class="fas fa-heart" style="font-size: 20px;"></i>');
        }

        // Update the HTML elements
        $("#like" + postNumber).text(countLike);
      },
      error: function () {
        console.log("An error occurred during the AJAX request.");
      }
    });
  }

  function postComment(cid, postNumber) {
    var mesg = document.getElementById('textAreaExample' + postNumber).value;

    $.ajax({
      url: "../Assets/AjaxPages/AjaxComment.php?coid=" + cid + "&msg=" + mesg,
      success: function (html) {
        $("#comcount" + postNumber).html(html);
        ViewComment(postNumber, cid);
        document.getElementById('textAreaExample' + postNumber).value = "";
        alert("your comment has been posted");
      },
      error: function () {
        console.log("An error occurred during the AJAX request.");
      }
    });
  }


  function ViewComment(postNumber, cid) {
    console.log(postNumber);
    $.ajax({
      url: "../Assets/AjaxPages/AjaxCommentView.php?postId=" + cid + "&postNumber=" + postNumber,
      success: function (html) {
        $("#viewComment" + postNumber).html(html);
      }
    });
  }

  function reportPost(rid, postNumber) {
    var msg = document.getElementById('message-text' + postNumber).value;
    $.ajax({
      url: "../Assets/AjaxPages/AjaxReportPost.php?reid=" + rid + "&mes=" + msg,
      success: function (html) {
        alert("the post has been reported");
      }
    });
  }
  function deleteComment(ccid, postId, postNumber) {
    $.ajax({
      url: "../Assets/AjaxPages/AjaxCusComment.php?ccid=" + ccid + "&postId=" + postId,
      success: function (html) {
        $("#comcount" + postNumber).html(html);
        ViewComment(postNumber, postId);
        alert("your comment is deleted");

      }
    });
  }
  const exampleModal = document.getElementById('exampleModal')
  if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', event => {
      // Button that triggered the modal
      const button = event.relatedTarget
      // Extract info from data-bs-* attributes

      // If necessary, you could initiate an Ajax request here
      // and then do the updating in a callback.


      // Update the modal's content.

      const modalBodyInput = exampleModal.querySelector('.modal-body input')


      modalBodyInput.value = recipient
    })
  }
</script>
<?php
ob_end_flush();
include('Foot.php');
?>

</html>