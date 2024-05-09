<?php
include('../Assets/Connection/Connection.php');
session_start();


$selQry = "select * from tbl_user where user_id=" . $_SESSION['uid'];
$result = $conn->query($selQry);
$data = $result->fetch_assoc();
$deliveryAddress = "";
if ($data['user_delivery_address'] == "") {
  $deliveryAddress = $data['user_address'];
} else {
  $deliveryAddress = $data['user_delivery_address'];

}

if (isset($_POST["btn_submit"])) {
  $address = $_POST["txt_address"];
  $upQry = "update tbl_user set user_delivery_address	='" . $address . "' where user_id = " . $_SESSION['uid'];
  if ($conn->query($upQry)) {
    $upQry2 = "update tbl_booking set booking_status = '1' where booking_id='" . $_SESSION["bid"] . "'";
    if ($conn->query($upQry2)) {
      $updQry3 = "update tbl_cart set cart_status = '1' where booking_id='" . $_SESSION["bid"] . "'";
      if ($conn->query($updQry3)) {
        ?>
        <script>
          alert("Redirecting")
          window.location = "Payment.php";
        </script>
        <?php
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    /* Custom styles for the bill */
    .bill-container {
      background-color: #f8f9fa;
      padding: 20px;
      border: 1px solid #d1d1d1;
      width: 60%;
    }

    .bill-header {
      text-align: center;
    }

    .bill-total {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .bill-card {
      margin: 10px 0;
    }

    .ptag {
      width: 100%;
      margin-top: 20px;
      border: 1px solid;
      border-radius: 15px;
      padding: 12px;
      padding-left: 30px;
      font-size: 16px;
    }

    .label {
      width: 50%;
      font-weight: 600;
    }
  </style>
</head>

<body onload="generateRandom6DigitNumber()">
  <?php
  $total = 0;
  $selectQry = "select * from tbl_booking where booking_id = " . $_SESSION['bid'];
  $result1 = $conn->query($selectQry);
  $data1 = $result1->fetch_assoc();
  ?>
  <form name="form1" method="post" action="">

    <div class="container bill-container">
      <div class="text-center bill-header">
        <h1>AQUA FISHES
          
        </h1>
       
      </div>


      <div class="row">
        <div class="col-md-12">
          <div class="form-group" class="ptag">


            <label for="txt_address" style="display: flex;">Address <label style=" width:25px; height:25px;border: 1px solid; border-radius:50%;margin-bottom: 10px;display: flex;justify-content: center;align-items: center;margin-left: 10px;" data-toggle="tooltip" data-placement="top"
          title="If You want to Change Delivery Address Change Below"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                  fill="currentColor" class="bi bi-info" viewBox="0 0 16 16">
                  <path
                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                </svg></label></label>

   
            <textarea class="form-control" name="txt_address" id="txt_address" rows="4" required
              autocomplete="off"><?php echo $deliveryAddress ?></textarea>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group" class="fmgrp">
            <p class="ptag">
              <label class="label">Name</label>

              <?php echo $data["user_name"] ?>
            </p>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <p class="ptag">
              <label class="label">Address</label>
              <?php echo $data["user_address"] ?>
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <p class="ptag">
              <label class="label">Contact</label>
              <?php echo $data["user_contact"] ?>
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <p class="ptag">
              <label class="label">Bill No.</label>
              <label id="billnumber"></label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <p class="ptag">
              <label class="label">Date</label>
              <?php echo $data1["booking_date"] ?>
                      </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <?php
          $sel4 = "select * from tbl_cart c inner join tbl_product p on c.product_id = p.product_id where booking_id = " . $data1['booking_id'];
          $result4 = $conn->query($sel4);
          while ($res1 = $result4->fetch_assoc()) {
            ?>
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title">Product Name</h5>
                <p class="card-text">
                  <?php echo $res1["product_name"] ?>
                </p>
                <h5 class="card-title">Quantity</h5>
                <p class="card-text">
                  <?php echo $res1["cart_quantity"] ?>
                </p>
                <h5 class="card-title">Price</h5>
                <p class="card-text">
                  <?php echo $res1["product_price"] * $res1['cart_quantity'] ?>
                </p>
                
              </div>
            </div>
            <?php
            $total += ($res1["product_price"] * $res1['cart_quantity']);
          }
          $gst = $total * 0.03567;
          ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Gst Amount</label>
            <p>
              <?php echo $gst . " Rs" ?>
            </p>
          </div>
          <div class="form-group">
            <label>Delivery Charge</label>
            <p>
              <?php echo "40" . " Rs" ?>
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group bill-total">
            <label>Total</label>
            <p>
              <?php echo $total+$gst+40 . " Rs" ?>
            </p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <input type="submit" class="btn btn-primary" style="width: 200px;height: 50px;" name="btn_submit"
              id="btn_submit" value="Pay">
          </div>
        </div>
      </div>
    </div>

  </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  // Generate a random 6-digit number
  function generateRandom6DigitNumber() {
  // Generate a random 6-digit number
  const random6DigitNumber = Math.floor(Math.random() * 900000) + 100000;

  // Display the number in an HTML element with the id 'billnumber'
  document.getElementById('billnumber').innerHTML = random6DigitNumber;
}

</script>

</html>