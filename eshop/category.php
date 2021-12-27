<!DOCTYPE HTML>
<html>

<?php
include 'session.php';
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<?php
include 'config/nav.php';
?>

<body>
    <!-- container -->
    <div class="container-fluid">
    <h1>Create Category</h1>
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $flag = 1;

                $query = "SELECT name FROM categories where name = ?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $name);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (is_array($row)) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Category name has used</div>";
                }

                // insert query
                if ($flag == 1) {
                    $query = "INSERT INTO categories SET name=:name";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // posted values
                    // bind the parameters
                    $stmt->bindParam(':name', $name);


                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
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
                    <td>Category Name</td>
                    <td><input type='text' name='name' class='form-control' minlength="1" required /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='categories_list.php' class='btn btn-danger'>Back to categories</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>