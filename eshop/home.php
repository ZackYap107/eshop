<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<?php
include 'config/nav.php';
include 'config/database.php';
$myUsername = $_SESSION["Username"];
?>

<body>
    <div class="container-fluid">
        <h1>Welcome</h1>
        <div class="col text-left py-2 ps-4 border bg-light">
            <?php
            echo "Today Date: ";
            echo date("M j, Y");
            echo "<br>";

            $query = "SELECT Username, LastName, Gender FROM customers where username=?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $Username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($Gender = 1) {
                echo " User : Mr " . $myUsername;
            } else {
                echo " User : Ms " . $myUsername;
            };

            ?>
        </div>

        <div class="container-fluid px-4 my-2 mb-3">
            <div class="row gx-1">
                <div class="col text-center border bg-light">
                    <p class="fw-bold text-uppercase pt-3">Total Order</p>
                    <div class="container-fluid px-4">
                        <div class="row gx-1">
                            <div class="col text-center border bg-light py-3">
                                <p class="fw-bold text-uppercase">Total Order</p>
                                <?php
                                $aquery = "SELECT * FROM orders ORDER BY order_id ASC";
                                $stmt = $con->prepare($aquery);
                                $stmt->execute();

                                // this is how to get number of rows returned
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    echo $num;
                                }
                                ?>
                            </div>
                            <div class="col text-center border bg-light py-3">
                                <p class="fw-bold text-uppercase">Total Product</p>
                                <?php

                                // select all data
                                $query = "SELECT id FROM products ORDER BY id DESC";
                                $stmt = $con->prepare($query);
                                $stmt->execute();

                                // this is how to get number of rows returned
                                $pnum = $stmt->rowCount();

                                if ($pnum > 0) {
                                    echo $pnum;
                                }

                                ?>
                            </div>
                            <div class="col text-center border bg-light py-3">
                                <p class="fw-bold text-uppercase">Total Customer</p>
                                <?php
                                // select all data
                                $query = "SELECT Username FROM customers ORDER BY Username DESC";
                                $stmt = $con->prepare($query);
                                $stmt->execute();

                                // this is how to get number of rows returned
                                $num = $stmt->rowCount();

                                if ($num > 0) {
                                    echo $num;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

        try {

            if (isset($myUsername)) {
                $query = "SELECT order_id, orderdetails.name as oname, max(order_date) as MaxDate
                                FROM orderdetails
                                WHERE orderdetails.name = ?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $myUsername);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //var_dump($row);

                // values to fill up our form
                $order_id = $row['order_id'];
                $oname = $row['oname'];
                $order_date = $row['MaxDate'];
            }

            if (isset($order_date)) {
                $query = "SELECT order_id, orders.customer as oname, quantity, max(order_date) as MaxDate, total_amount
                FROM orders
                WHERE orders.order_date = ?";
                
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $order_date);
                //var_dump($row);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $quantity = $row['quantity'];
                    $total_amount = $row['total_amount'];
                }
            }

        ?>
            <div class="container-fluid px-4">
                <div class="row gx-5">
                    <div class="col">
                        <div class="p-3 border bg-light text-left">
                            <h3>Lastest Order</h3>
                            <div class='col-5'>Order ID : </td>
                                <td class='col-6'><?php echo "OID " . $order_id ?>
                            </div>
                            <div class='col-5'>Customer Name : </td>
                                <td class='col-6'><?php echo $oname ?>
                            </div>
                            <div class='col-5'>Total Amount : </td>
                                <td class='col-6'><?php echo $total_amount ?>
                            </div>
                            <div class='col-5'>Order Date : </td>
                                <td class='col-6'><?php echo $order_date ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
    </div> <!-- end .container -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>