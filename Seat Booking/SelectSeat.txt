<?php
if(isset($_POST['btnsubmit'])){
  $seats = $_POST['seats'];
  foreach ($seats as $key => $value) {
    echo "Selected Seat: " . $value . "<br>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      .seat-box{
        display: flex;
    justify-content: center;
    margin: 30px;
      }
      .seat-label{
        margin: 0;
      }
        .checkbox-container {
      position: relative;
      display: inline-block;
      cursor: pointer;
      margin: 2px;
    }

    input[type="checkbox"] {
      display: none; /* Hide the default checkbox */
    }

    /* Style the Font Awesome icon */
    .fa-couch::before {
      font-size: 24px; /* Set the font size as needed */
    }

    /* Define styles for the checked state */
    input[type="checkbox"]:checked + i.fa-couch::before {
      /* Add styles for the checked state if desired */
      color:blue;
    }

    input[type="submit"] {
      border: none;
      padding: 10px;
    background-color: #20af20;
    color: white;
    border-radius: 5px;
    width: 100px;
    }
    </style>
</head>
<body>
  <form action="" method="post">
    <div class="seat-box">
        <div class="row">
          <?php
        $seats = 100;
for ($i = 1; $i <= $seats; $i++) {
  ?>
    <label class='checkbox-container'>
    <input type='checkbox' id='custom-checkbox' name='seats[]' value='$i'>
    <i class='fas fa-couch'></i>
    <p class='seat-label' align='center'><?php echo $i ?></p>
    </label>
    <?php

    if ($i % 10 == 0) {
        echo "<br><hr>";
    }

    else if ($i % 5 == 0) {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
}
?>
           
        </div>
    </div>
    <div align='center'>
    <input type="submit" value="Submit" name='btnsubmit'>

    </div>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
  const checkbox = document.getElementById("custom-checkbox");
  checkbox.addEventListener("change", function () {
    if (checkbox.checked) {
        // console.log(checkbox.value);
      console.log("Checkbox is checked");
    } else {
      console.log("Checkbox is unchecked");
    }
  });
</script>
</html>