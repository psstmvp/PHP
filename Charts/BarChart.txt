<?php
ob_start();
include("Head.php");
include("../Assets/Connection/Connection.php");
$xValues = [];
$yValues = [];
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bar Chart Report</title>
	<link rel="icon" type="image/x-icon" href="../Assets/File/Admin/Artisanal_icon.png" />
    <!-- Include necessary CSS and JavaScript libraries -->
    <script src="../Assets/JQ/jQuery.js "></script>
</head>

<body>
    <div class="content-wrapper">
        <div class="content-wrapper">

            <form id="form1" name="form1" method="post" action="">
                <center>
                    <div class="col-lg-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">select the Dates here</h4>
                                <table>
                                    <tr>
                                        
                                        <td><label for="txt_f">From Date</label>
                                            <input type="date" name="txt_f" id="txt_f" class="form-control">
                                        </td>
                                       
                                        <td><label for="txt_t">To Date</label>
                                            <input type="date" name="txt_t" id="txt_t" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div style="margin:15px;text-align:center;">
                                                <input type="submit" name="btnsave" id="btnsave" class="btn btn-primary"
                                                    style="background-color:#2865AF;" value="View Results" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </center>


                <center>
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sales By Category -Bar chart</h4>
                                <h4><?php if(isset($_POST['btnsave'])){ echo " between " . $_POST["txt_f"]. " and " . $_POST["txt_t"] ; }?></h4>
                                <canvas id="barChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </center>


                <?php
                if (isset($_POST["btnsave"])) {

                    $sel = "select * from tbl_category";
                    $row = $conn->query($sel);
                    while ($data = $row->fetch_assoc()) {
                        $xValues[] = $data["category_name"];
                        $sel1 = "select sum(cart_quantity) as id from tbl_cart ca inner join  tbl_order b on b.order_id=ca.order_id inner join tbl_customer u on u.customer_id=b.customer_id inner join  tbl_product p on ca.product_id=p.product_id inner join tbl_subcategory su on su.subcat_id=p.subcat_id inner join tbl_category c on c.category_id=su.category_id WHERE ( cart_status in (1,3,4) and c.category_id='" . $data["category_id"] . "' and order_date between '" . $_POST["txt_f"] . "' and '" . $_POST["txt_t"] . "')";
                        $row1 = $conn->query($sel1);
                        while ($data1 = $row1->fetch_assoc()) {
                            $yValues[] = $data1["id"];
                        }
                    }
                    ?>

                    <div class="col-lg-12 grid-margin stretch-card" style="margin-top:30px">
                        <div class="card">
                            <div class="card-body">
                                <div id="pri">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Sl.no</th>
                                                    <th style="text-align:center;">product name</th>
                                                    <th style="text-align:center;">quantity <br>on each order</th>
                                                    <th style="text-align:center;">category</th>
                                                    <th style="text-align:center;">subcategory</th>
                                                    <th style="text-align:center;">Ordered On</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $sel = " select * from tbl_order o inner join tbl_cart ca on o.order_id=ca.order_id inner join tbl_product p on ca.product_id=p.product_id inner join tbl_subcategory su on su.subcat_id=p.subcat_id inner join tbl_category c on c.category_id=su.category_id WHERE ( cart_status in (1,3,4) and  o.order_date between '" . $_POST["txt_f"] . "' and '" . $_POST["txt_t"] . "')";
                                                $row = $conn->query($sel);
                                                $i = 0;
                                                while ($data = $row->fetch_assoc()) {
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $i ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data["prod_name"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data["cart_quantity"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data["category_name"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data["subcat_name"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $data["order_date"]; ?>
                                                        </td>


                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <center><input type="button" onclick="printDiv('pri')" id="invoice-print"
                                        class="btn btn-success" value="Print" /></center>
                            </div>
                        </div>
                    </div>

                    <?php
                } else {

                    $sel = "select * from tbl_category";
                    $row = $conn->query($sel);
                    while ($data = $row->fetch_assoc()) {
                        $xValues[] = $data["category_name"];
                        $sel1 = "select sum(cart_quantity) as id from tbl_cart ca inner join  tbl_order b on b.order_id=ca.order_id inner join tbl_customer u on u.customer_id=b.customer_id inner join  tbl_product p on ca.product_id=p.product_id inner join tbl_subcategory su on su.subcat_id=p.subcat_id inner join tbl_category c on c.category_id=su.category_id WHERE ( cart_status in (1,3,4) and c.category_id='" . $data["category_id"] . "') ";
                        $row1 = $conn->query($sel1);
                        while ($data1 = $row1->fetch_assoc()) {
                            $yValues[] = $data1["id"];
                        }
                    }
                }
                ?>

            </form>
        </div>
</body>

<?php
$xValuesJson = json_encode($xValues);
$yValuesJson = json_encode($yValues);
?>

<script>


    $(function () {
        'use strict';

        var xValues = <?php echo $xValuesJson; ?>;
        var stringArray = <?php echo $yValuesJson; ?>;
        const yValues = stringArray.map(str => Number(str));

        function generatePastelBrightColorPalettes(numColors) {
            const fillColors = [];
            const borderColors = [];
            const colorStep = 360 / numColors;
            for (let i = 0; i < numColors; i++) {
                const hue = Math.round(i * colorStep);

                // Generate pastel RGB values for bright colors
                const saturation = 50 + Math.random() * 30; // Adjust the saturation range
                const lightness = 65 + Math.random() * 30;  // Adjust the lightness for pastel effect

                const fillColor = `hsla(${hue}, ${saturation}%, ${lightness}%, 0.65)`; // 0.5 alpha value for fill
                const borderColor = `hsla(${hue}, ${saturation}%, ${lightness}%, 1)`;  // 1 alpha value for border

                fillColors.push(fillColor);
                borderColors.push(borderColor);
            }
            return { fillColors, borderColors };
        }

        // Call the function with the number of colors:
        const { fillColors, borderColors } = generatePastelBrightColorPalettes(xValues.length);

        var data = {
            labels: xValues,
            datasets: [{
                label: '# of orders',
                data: yValues,
                backgroundColor: fillColors,
                borderColor: borderColors,
                borderWidth: 1,
                fill: false
            }]
        };

        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: data,
                options: {
                    // You can configure chart options here
                }
            });
        }
    });
</script>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

<?php
include("Foot.php");
ob_flush();
?>

</html>