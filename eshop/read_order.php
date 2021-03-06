<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<?php
include 'config/nav.php';
?>
<body>

    <!-- container -->

    <div class="container-fluid">
        <div class="page-header">
            <h1>Read Order</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $proid = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record order id not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT orderdetails.order_id as oid, orderdetails.name as oname, orderdetails.product_id as opid, orderdetails.quantity as quantity, orderdetails.order_date as order_date, products.price as pprice, products.id as pid, products.name as pname
            FROM orderdetails
            INNER JOIN products 
            ON orderdetails.product_id = products.id
            WHERE order_id = ?";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $proid);
            // execute our query
            $stmt->execute();
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // values to fill up our form
            $order_id = $row['oid'];
            $customer = $row['oname'];
            $pid = $row['pid'];
            $pname = $row['pname'];
            $quantity = $row['quantity'];
            $order_date = $row['order_date'];
            $pprice = $row['pprice'];
            $totalamount = 0;
            $total = 0;
            
        ?>
            <table class='table table-hover table-responsive table-bordered'>
                <tr><th class='col-5'>Order Date</td><td class='col-6'><?php echo $order_date ?></th></tr>
                <tr><th class='col-5'>Customer Name</td><td class='col-6'><?php echo $customer ?></th></tr>
                <tr><th class='col-5'>Order ID</td><td class='col-6'><?php echo $order_id ?></th></tr>
            </table>
            <?php

            $num = $stmt->rowCount();
    
            //check if more than 0 record found
            if ($num > 0) {
                echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

                //creating our table heading
                echo "<tr>";
                echo "<th>Product ID</th>";
                echo "<th>Product Name</th>";
                echo "<th>Quantity</th>";
                echo "<th>Price (RM)</th>";
                echo "<th>Total (RM)</th>";
                echo "</tr>";

                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$pid}</td>";
                echo "<td>{$pname}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>RM {$pprice}</td>";
                $total = ($pprice * $quantity);
                echo "<td>RM {$total}</td>";
                $totalamount = $totalamount + $total;
                echo "</tr>";
                }
                
                //echo "<table class='table table-hover table-responsive table-bordered col-5'>";
                //echo "<tr>";
                //echo "<tr><th class='col-5'>Total Amount (RM)</th><td class='col-6'>RM {$totalamount}</td></tr>";
                //echo "</table>";
                //echo "</tr>";
            }
            // if no records found
            else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
                ?>
            <?php
        }
        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <tr>
            <td colspan = "3">
                <?php echo "<th>Total Amount (RM)</th><td class='col-3'>RM {$totalamount}</td>"; ?>
            </td>
        </tr>
        <tr>
            <td colspan = "6">
                <a href='order_list.php' class='btn btn-danger'>Back to read Order List</a>
            </td>
        </tr>
        </table>
    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>