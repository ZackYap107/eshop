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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Online Eshop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

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
                <tr><td class='col-5'>Order Date</td><td class='col-6'><?php echo $order_date ?></td></tr>
                <tr><td class='col-5'>Customer Name</td><td class='col-6'><?php echo $customer ?></td></tr>
                <tr><td class='col-5'>Order ID</td><td class='col-6'><?php echo "OID ". $order_id ?></td></tr>
            </table>
            <?php

            /*$query = "SELECT orders.order_id, customer, order_date, total_amount
            FROM orders ORDER BY orders.order_id ASC";
            */
            //$totalamount = $row['total_amount'];
            //$stmt = $con->prepare($query);
            //$stmt->execute();
            //$stmt->bindParam(':categories', $categories);
            // this is how to get number of rows returned
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
                echo "<table class='table table-hover table-responsive table-bordered col-5'>";
                echo "<tr><td class='col-5'>Total Amount (RM)</td><td class='col-6'>RM {$totalamount}</td></tr>";
                echo "</table>";
            }
            // if no records found
            else {
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            /*
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
                    extract($row);
                    echo "<table class='table table-hover table-responsive table-bordered class='col-5'>";
                    echo "<tr><td class='col-5'>Product ID</td><td class='col-6'>{$pid}</td></tr>";
                    echo "<tr><td class='col-5'>Product Name</td><td class='col-6'>{$pname}</td></tr>";
                    echo "<tr><td class='col-5'>Quantity</td><td class='col-6'>{$quantity}</td></tr>";
                    echo "<tr><td class='col-5'>Price</td><td class='col-6'>{$pprice}</td></tr>";
                    $total = ($pprice * $quantity);
                    echo "<tr><td>Total</td><td colspan='7'>{$total}</td></tr>";
                    $totalamount = $totalamount + $total;
                    echo "</table>";
                }
                
                    echo "<table class='table table-hover table-responsive table-bordered col-5'>";
                    echo "<tr><td class='col-5'>Total Amount</td><td class='col-6'>{$totalamount}</td></tr>";
                    echo "</table>";
            */
                ?>
            <?php
        }
        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <tr>
            <td colspan = "6">
                <a href='order_list.php' class='btn btn-danger'>Back to read Order List</a>
            </td>
        </tr>
        </table>
    </div> <!-- end .container -->
</body>
</html>