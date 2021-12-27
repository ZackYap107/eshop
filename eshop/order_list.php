<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<?php
include 'config/nav.php';
?>

<body>

    <!-- container -->
    <div class="container-fluid">
    <h1>Order List</h1>
        <td>
            <?php
            echo "<a href='order.php' class='btn btn-primary m-b-1em col-2 my-2'>Order Now</a>";
            ?>
        </td>

        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        $query = "SELECT orders.order_id, customer, order_date
        FROM orders ORDER BY orders.order_id ASC";

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
            echo "<th>Name</th>";
            echo "<th>Order Date</th>";
            echo "</tr>";

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$customer}</td>";
                echo "<td>{$order_date}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_order.php?order_id={$order_id}' class='btn btn-info m-r-1em'> Order Detail </a>";

                // we will use this links on next part of this post
                //echo "<a href='update.php?order_id={$order_id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user(\"{$order_id}\");'  class='btn btn-danger'>Delete</a>";
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

            var answer = confirm('Are you sure to delete this order?');
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