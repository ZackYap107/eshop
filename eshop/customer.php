<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Register</h1>
        </div>
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO customers SET Username=:Username, Password=:Password, FirstName=:FirstName, LastName=:LastName, Gender=:Gender, dob=:dob, AccountStatus=:AccountStatus";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $Username = htmlspecialchars(strip_tags($_POST['Username']));
                $Password = htmlspecialchars(strip_tags($_POST['Password']));
                $FirstName = htmlspecialchars(strip_tags($_POST['FirstName']));
                $LastName = htmlspecialchars(strip_tags($_POST['LastName']));
                $Gender = htmlspecialchars(strip_tags($_POST['Gender']));
                $dob = htmlspecialchars(strip_tags($_POST['dob']));
                $AccountStatus = htmlspecialchars(strip_tags($_POST['AccountStatus']));
                // bind the parameters
                $stmt->bindParam(':Username', $Username);
                $stmt->bindParam(':Password', $Password);
                $stmt->bindParam(':FirstName', $FirstName);
                $stmt->bindParam(':LastName', $LastName);
                $stmt->bindParam(':Gender', $Gender);
                $stmt->bindParam(':dob', $dob);
                $stmt->bindParam(':AccountStatus', $AccountStatus);
                // specify when this record was inserted to the database
                //$created = date('Y-m-d H:i:s');
                //$stmt->bindParam(':created', $created);
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

        < !-- html form here where the customers information will be entered -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Username</td>
                        <td><input type='text' name='Username' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type='password' name='Password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>FirstName</td>
                        <td><input type='text' name='FirstName' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>LastName</td>
                        <td><input type='text' name='LastName' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><input type='text' name='Gender' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>dob</td>
                        <td><input type='date' name='dob' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td>AccountStatus</td>
                        <td><input type='text' name='AccountStatus' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='index.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>