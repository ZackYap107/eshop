<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>
<?php
include 'config/nav.php';
?>

<body>
    <!-- container -->
    <div class="container-fluid">
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, category, description, price, promotion_price, manufacture_date, expired_date FROM products WHERE id = ?";
            /*
            $query = "SELECT products.id as id, products.name, category, description, price, promotion_price, manufacture_date, expired_date, categories.id as cid, categories.name as cname FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.id WHERE id = ?";
            */
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $ccid = $row['category'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$cname}</td>";
                echo "<td>{$description}</td>";
                echo "<td>${$price}</td>";
                echo "<td>${$promotion_price}</td>";
                echo "<td>${$manufacture_date}</td>";
                echo "<td>${$expired_date}</td>";
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
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php

        // check if form was submitted
        if ($_POST) {
            try {
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $cname = htmlspecialchars(strip_tags($_POST['category']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                $expired_date = htmlspecialchars(strip_tags($_POST['expired_date']));
                $flag = 1;

                if ($name == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in your product name</div>";
                }
                if ($cname == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in your product category</div>";
                }
                if ($description == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in your product description</div>";
                }
                if ($price == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in your product price</div>";
                }
                if ($manufacture_date == "") {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Please fill in your manufacture date</div>";
                }

                if ($flag == 1) {
                    $query = "UPDATE products
                    SET name=:name, category=:category, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date WHERE id = :id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':category', $cname);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $stmt->bindParam(':price', $price);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>id</td>
                    <td><?php echo htmlspecialchars($id, ENT_QUOTES);  ?> </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>category</td>
                    
                    <td>
                        <select class="p-2" aria-label="Default select example" name="category">
                            <?php
                            $query = "SELECT categories.id as cid, categories.name as cname FROM categories";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            //$num = $stmt->rowCount();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                echo "<option value='$cid' name='$'";
                                if ($ccid == $cid) {
                                    echo "selected";
                                }
                                echo ">$cname</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='number' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='number' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
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