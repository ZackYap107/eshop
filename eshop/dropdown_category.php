<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    
    <div class="dropdown">
        <tr>
            <td>
                <?php
                echo "<a href='create.php' class='btn btn-primary m-b-1em '>Create New Product</a>";
                ?>
            </td>
            <td></td>
            <td>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Categories Filter
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="readProducts.php">All Category</a></li>
                    <li><a class="dropdown-item" href="#" value="1">General</a></li>
                    <li><a class="dropdown-item" href="#" value="2">Sport</a></li>
                    <li><a class="dropdown-item" href="#" value="3">Engine</a></li>
                </ul>
            </td>
        </tr>
    </div>

    <?php
    /*
    if ($_POST) {
        try {
            $query = "SELECT products.id, products.name, category, description, price, promotion_price, manufacture_date, expired_date, categories.id, categories.name as cname FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
        }
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
    }
    
    //?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?category={$category}"); ?>" method="POST">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><input type='text' name='name' value="" class='form-control' /></td>
            </tr>
            <tr>
                <td>category</td>
                <td><input type='text' name='category' value="" class='form-control' /></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name='description' class='form-control'></textarea></td>
            </tr>

        </table>
    </form> */
    ?>
</body>

</html>