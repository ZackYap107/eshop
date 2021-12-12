<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <!-- container -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Online Eshop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Read Order List</h1>
        </div>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record order ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT create_order.order_id, name, category, products, quantity, order_date, price, total_price FROM create_order WHERE create_order.order_id = ? LIMIT 0,1";

            /*$query = "SELECT create_order.order_id, name, category, products, quantity, order_date, price, total_price, categories.id as cid, categories.name as cname
            FROM create_order 
            INNER JOIN categories ON create_order.category = categories.id ORDER BY create_order.order_id ASC";
            */

            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $order_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $order_id = $row['order_id'];
            $name = $row['name'];
            $category = $row['category'];
            $products = $row['products'];
            $quantity = $row['quantity'];
            $order_date = $row['order_date'];
            $price = $row['price'];
            $total_price = $row['total_price'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>


        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Order ID</td>
                <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?> </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>category</td>
                
                <td><?php echo htmlspecialchars($category, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>products</td>
                <td><?php echo htmlspecialchars($products, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>quantity</td>
                <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>order_date</td>
                <td><?php echo htmlspecialchars($order_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>price</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>total_price</td>
                <td><?php echo htmlspecialchars($total_price, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='order_list.php' class='btn btn-danger'>Back to read Order List</a>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->

</body>

</html>