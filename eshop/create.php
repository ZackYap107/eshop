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
include 'config/database.php';
?>

<body>
    <!-- container -->
    <div class="container-fluid">
    <h1>Create Product</h1>
        <?php


        $query = "SELECT categories.id as cid, categories.name as cname FROM categories";
        $stmt = $con->prepare($query);


        if ($_POST) {
            
            try {
                // insert query
                $query = "INSERT INTO products SET name=:name, category=:category, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date	, expired_date=:expired_date ,created=:created";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $cid = htmlspecialchars(strip_tags($_POST['cid']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));
                // bind the parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':category', $cid);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':promotion_price', $promotion_price);
                $stmt->bindParam(':manufacture_date', $manufacture_date);
                $stmt->bindParam(':expired_date', $expired_date);
                // specify when this record was inserted to the database
                $created = date('Y-m-d H:i:s');
                $stmt->bindParam(':created', $created);


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
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' minlength="1" required/></td>
                </tr>
                <tr>
                    <td>category</td>
                    <td><select class="w-25 col-2 p-2" aria-label="Default select example" name="cid">
                            <option value="0" name="a" selected>Select Category</option>
                            <?php
                            $cquery = "SELECT categories.id as cid, categories.name as cname FROM categories";
                            $stmt = $con->prepare($cquery);
                            $stmt->execute();
                            $num = $stmt->rowCount();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                echo "<option value='$cid' name='$'>$cname</option>";
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control' minlength="1" required></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' class='form-control' minlength="1" required/></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='number' name='promotion_price' class='form-control'/></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' required /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='readProducts.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>