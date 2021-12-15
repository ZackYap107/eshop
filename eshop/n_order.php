<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="menu">
        <?php include 'config/nav.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Order</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST'>
            <table class='table table-hover table-responsive table-bordered'>
                <?php
                include 'config/database.php';
                $flag = 1;

                if ($_POST) {

                        echo "<pre>";
                        var_dump($_POST);
                        echo "</pre>";
                    
                    /*
                        $pp=$_POST['product_id'];
                        $qq =$_POST['quantity'];
                        echo $pp[0]."=".$qq[0]."<br>";
                        echo $pp[1]."=".$qq[1]."<br>";
                        echo $pp[2]."=".$qq[2]."<br>";
                    */

                    // posted values
                    $customer = $_POST['customer'];
                    //$product_id = $_POST['product_id'];
                    $quantity = $_POST['quantity'];
                    // insert query
                    $query = "INSERT INTO orders SET customer=:customer, quantity=:quantity";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':customer', $customer);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->execute();
                    $id = $con->lastInsertId();
                    echo "<div class='alert alert-success'>Record was saved. The Order ID is $id.</div>";

                    if ($flag == 1) {
                        for ($y = 0; $y < count($product_id); $y++) {
                            //insert query
                            $query = "INSERT INTO orderdetails SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                            // prepare query for execution
                            $stmt = $con->prepare($query);

                            // bind the parameters
                            $stmt->bindParam(':order_id', $id);
                            $stmt->bindParam(':product_id', $product_id[$y]);
                            $stmt->bindParam(':quantity', $quantity[$y]);

                            //echo $product_id[$y];
                            //echo $quantity[$y];
                            //echo "<br>";

                            $stmt->execute();
                        }
                    }
                }

                echo "<tr>";
                echo "<td>Customer ID</td>";
                echo "<td>";
                $query = "SELECT FirstName , LastName, Username FROM customers ORDER BY username DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    echo "<select class='form-select' aria-label='Default select example' name='customer'>";
                    echo "<option value='A'>Username</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value=$Username>$FirstName $LastName";
                        echo "</option>";
                    }
                    echo "</select>";
                }
                echo "</td>";
                echo "</tr>";
                ?>


                <div class="container">
                    <table id="order_table" class='table table-hover table-responsive table-bordered'>
                        <tr class='productQuantity'>
                            <td>Product</td>
                            <td>
                                <div>
                                    <select class='form-select' name='productID[]'>
                                        <option value=''>Select Product</option>
                                        <?php
                                        $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                        $productstmt = $con->prepare($productquery);
                                        //$orderQuantityA++; //+1
                                        $productstmt->execute();
                                        $productnum = $productstmt->rowCount();

                                        //$stmt->bindParam(':quantity', $product_id[$orderQuantityA]);
                                        if ($productnum > 0) {

                                            //echo "<select class= 'form-select' aria-label='Default select example' name='product_id[]'>";
                                            //echo "<option value='A'>Product</option>";
                                            while ($row = $productstmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                                //echo "Select Product";
                                                echo "<option value=$id>$name";
                                                echo "</option>";
                                            }
                                        }
                                        ?>>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <select class='form-select' name='quantity[]'>
                                        <option value=''>Select Quantity</option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type='submit' value='Submit' class='btn btn-primary' /></td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-center flex-column flex-lg-row">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="add_one btn mb-3 mx-2">Add More Product</button>
                            <button type="button" class="del_last btn mb-3 mx-2">Delete Last Product</button>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
                <script>
                    document.addEventListener('click', function(event) {
                        if (event.target.matches('.add_one')) {
                            var element = document.querySelector('.productQuantity');
                            var clone = element.cloneNode(true);
                            element.after(clone);
                        }
                        if (event.target.matches('.del_last')) {
                            var total = document.querySelectorAll('.productQuantity').length;
                            if (total > 1) {
                                var element = document.querySelector('.productQuantity');
                                element.remove(element);
                            }
                        }
                    }, false);
                </script>


                <?php
                /*
                for ($x = 0; $x < 5; $x++) {
                ?>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col">
                                <?php
                                $orderQuantityA = 0;
                                $orderQuantityB = 0;
                                
                                $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                $productstmt = $con->prepare($productquery);


                                //$orderQuantityA++; //+1
                                $productstmt->execute();
                                $productnum = $productstmt->rowCount();

                                //$stmt->bindParam(':quantity', $product_id[$orderQuantityA]);
                                if ($productnum > 0) {

                                    echo "<select class= 'form-select' aria-label='Default select example' name='product_id[]'>";
                                    echo "<option value='A'>Product</option>";
                                    while ($row = $productstmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        echo "<option value=$id>$name";
                                        echo "</option>";
                                    }
                                    echo "</select>";
                                }
                            }
                                ?>
                                </div>
                        </td>
                        <div class="container">
                            <table id="order_table" class='table table-hover table-responsive table-bordered'>
                                <tr class='productQuantity'>
                                    <td>Product</td>
                                    <td>
                                        <div>
                                            <select class='form-select' name='productID[]'>
                                                <option value=''>-- Select Product --</option>
                                                <?php
                                                $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                                $productstmt = $con->prepare($productquery);


                                                //$orderQuantityA++; //+1
                                                $productstmt->execute();
                                                $productnum = $productstmt->rowCount();

                                                //$stmt->bindParam(':quantity', $product_id[$orderQuantityA]);
                                                if ($productnum > 0) {

                                                    echo "<select class= 'form-select' aria-label='Default select example' name='product_id[]'>";
                                                    echo "<option value='A'>Product</option>";
                                                    while ($row = $productstmt->fetch(PDO::FETCH_ASSOC)) {
                                                        extract($row);
                                                        echo "<option value=$id>$name";
                                                        echo "</option>";
                                                    }
                                                    echo "</select>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <select class='form-select' name='quantity[]'>
                                                <option value=''>-- Select Quantity --</option>
                                                <option value='1'>1</option>
                                                <option value='2'>2</option>
                                                <option value='3'>3</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-center flex-column flex-lg-row">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="add_one btn mb-3 mx-2">Add More Product</button>
                                    <button type="button" class="del_last btn mb-3 mx-2">Delete Last Product</button>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
                        <script>
                            document.addEventListener('click', function(event) {
                                if (event.target.matches('.add_one')) {
                                    var element = document.querySelector('.productQuantity');
                                    var clone = element.cloneNode(true);
                                    element.after(clone);
                                }
                                if (event.target.matches('.del_last')) {
                                    var total = document.querySelectorAll('.productQuantity').length;
                                    if (total > 1) {
                                        var element = document.querySelector('.productQuantity');
                                        element.remove(element);
                                    }
                                }
                            }, false);
                        </script>
                        
                    <tr>
                        <td colspan="2"><input type='submit' value='Submit' class='btn btn-primary' /></td>
                    </tr>
                    */
                ?>
            </table>
        </form>
    </div>
</body>

</html>