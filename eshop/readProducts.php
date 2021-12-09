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
        <div class="dropdown row">
        <tr>
            <td>
                <?php
                echo "<a href='create.php' class='btn btn-primary m-b-1em col-2 ms-3 my-2'>Create New Product</a>";
                ?>
            </td>
            <td></td>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <td>
                <select class="w-25 col-2 p-2" aria-label="Default select example" name="categories">
                <option value="0" name="a" selected>All Category</option>
                <option value="1" name="g">General</option>
                <option value="2" name="s">Sport</option>
                <option value="3" name="e">Engine</option>
                </select>
            </td>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Submit' class='btn btn-secondary col-2 m-2' />
                </td>
            </tr>
            </form>         
        </tr>
    </div>
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        
        //0 = all categories
        $categories = 0;

        
        if($_POST){
            //get post data from form when submit such as (0,1,2,3) value
            $categories = $_POST["categories"];
        }

        if($categories > 0){
            // select selection category data
            $query = "SELECT products.id as id, products.name, category, description, price, promotion_price, manufacture_date, expired_date, categories.id as cid, categories.name as cname FROM products  INNER JOIN categories ON products.category = categories.id WHERE categories.id = $categories ORDER BY products.id ASC ";

        }else{
            // select all data
            $query = "SELECT products.id as id, products.name, category, description, price, promotion_price, manufacture_date, expired_date, categories.id as cid, categories.name as cname FROM products INNER JOIN categories ON products.category = categories.id ORDER BY products.id ASC";
        }

        
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
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>category</th>";
            echo "<th>Description</th>";
            echo "<th>Price</th>";
            echo "<th>Promotion Price</th>";
            echo "<th>Manufacture Date</th>";
            echo "<th>Expired Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

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
                echo "<td>{$price}</td>";
                echo "<td>{$promotion_price}</td>";
                echo "<td>{$manufacture_date}</td>";
                echo "<td>{$expired_date}</td>";
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
        function delete_user(id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>