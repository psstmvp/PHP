<?php
include("../Connection/Connection.php");
session_start();
$uid = $_SESSION['uid'];

?>

<div class="scroll-container">
    <div>
        <?php
        $selcom = "select * from tbl_comments where post_id=" . $_GET['postId'] . "";
        $rescom = $conn->query($selcom);
        while ($rowcom = $rescom->fetch_assoc()) {
            $cuscom = "select *from tbl_customer where customer_id=" . $rowcom['customer_id'] . "";
            $recuscom = $conn->query($cuscom);
            $comrow = $recuscom->fetch_assoc();

            ?>
            <div class="d-flex mb-3">
                <img src="../Assets/File/Customer/<?php echo $comrow['cus_photo']; ?>" class="border rounded-circle me-2"
                    alt="Avatar" style="height: 40px" />
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
                            $selQry = "select * from tbl_comments where comment_id=" . $rowcom['comment_id'] . "";
                            $res = $conn->query($selQry);
                            $row = $res->fetch_assoc();
                            $postId = $row['post_id'];
                            ?>
                            
                            <button value="<?php echo $rowcom['comment_id'] ?>" style="text-decoration:none"
                              class="btn btn-link btn-lg" data-mdb-ripple-color="dark"
                              onclick="deleteComment(this.value,<?php echo $postId ?>,<?php echo $_GET['postNumber'] ?>)"
                              >

                              <i class="fa fa-trash me-2" style="font-size: 10 px;"></i> delete</a>
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