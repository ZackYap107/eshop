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
?>

<body>

    <!-- container -->
    <div class="container">

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }
        
        $query = "SELECT create_order.order_id as id, category, products, quantity, order_date, price, total_price, categories.id as cid, categories.name as cname
        FROM create_order 
        INNER JOIN categories ON create_order.category = categories.id ORDER BY create_order.order_id ASC";
        
        $stmt = $con->prepare($query);
        $stmt->execute();
        //$stmt->bindParam(':categories', $categories);
        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Category</th>";
            echo "<th>Products</th>";
            echo "<th>Quantity</th>";
            echo "<th>Order Date</th>";
            echo "<th>Price</th>";
            echo "<th>Total Price</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$cname}</td>";
                echo "<td>{$products}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>{$order_date}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$total_price}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>


    </div> <!-- end .container -->

    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(order_id) {

            var answer = confirm('Are you sure to delete this product?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'delete_order.php?order_id=' + order_id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>