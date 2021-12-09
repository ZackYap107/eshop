<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<?php
include 'config/nav.php';
?>

<body>
    <!-- container -->
    <div class="container">

        <?php
        /*if ($price !== NULL && $quantity !== NULL) {
            $total_price = $quantity * $price;
        }
        */
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO order SET category=:category, products=:products, quantity=:quantity, price=:price, total_price=:total_price";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $category = htmlspecialchars(strip_tags($_POST['category']));
                $products = htmlspecialchars(strip_tags($_POST['products']));
                $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $total_price = htmlspecialchars(strip_tags($_POST['total_price']));
                // bind the parameters
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':products', $products);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':total_price', $total_price);
                // specify when this record was inserted to the database

                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Category</td>
                    <td><input type='text' name='category' class='form-control' minlength="1" required /></td>
                </tr>
                <tr>
                    <td>Products</td>
                    <td><textarea name='products' class='form-control' minlength="1" required></textarea></td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td><input type='number' name='quantity' class='form-control' minlength="1" required /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Total Price</td>
                    <td><?php echo htmlspecialchars($total_price, ENT_QUOTES); ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='order_list.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>