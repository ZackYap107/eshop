<!DOCTYPE HTML>
<html>

<head>
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

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $Username = isset($_GET['Username']) ? $_GET['Username'] : die('ERROR: Record User not found.');

        //include database connection
        include 'config/database.php';
        include 'session.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT Username, Password, FirstName, LastName, Gender, dob FROM customers WHERE Username = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $Username);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $Username = $row['Username'];
            $Password = $row['Password'];
            $FirstName = $row['FirstName'];
            $LastName = $row['LastName'];
            $Gender = $row['Gender'];
            $dob = $row['dob'];

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$Username}</td>";
                echo "<td>{$Password}</td>";
                echo "<td>{$FirstName}</td>";
                echo "<td>${$LastName}</td>";
                echo "<td>${$Gender}</td>";
                echo "<td>${$dob}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_one.php?Username={$Username}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='update.php?Username={$Username}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$Username});'  class='btn btn-danger'>Delete</a>";
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
                // posted values
                //$Username = htmlspecialchars(strip_tags($_POST['Username']));
                $oPassword = htmlspecialchars(strip_tags($_POST['oPassword']));
                $Password = htmlspecialchars(strip_tags($_POST['Password']));
                $cPassword = htmlspecialchars(strip_tags($_POST['cPassword']));
                $FirstName = htmlspecialchars(strip_tags($_POST['FirstName']));
                $LastName = htmlspecialchars(strip_tags($_POST['LastName']));
                $Gender = htmlspecialchars(strip_tags($_POST['Gender']));
                $dob = htmlspecialchars(strip_tags($_POST['dob']));
                $year = substr($dob, 0, 4);
                $tyear = date("Y");
                $age = $tyear - $year;
                $pp = 1;
                $np = 1;
                
                if($oPassword == "" || $Password == "" || $cPassword == ""){
                    $pp = 1;
                    if ($oPassword != $Password){
                        echo "<div class='alert alert-danger'>Old Password does not match</div>";
                    } else if ($Password || $oPassword || $cPassword < 6){
                        echo "<div class='alert alert-danger'>Password must more than 6 digit</div>";
                    } else if ($Password != $cPassword){
                        echo "<div class='alert alert-danger'>Comfirm Password does not match</div>";
                    }
                } else {
                    $pp = 0;
                }

                
                if ($age <= 18) {
                    echo "<div class='alert alert-danger'>User to be greater than 18 years old</div>";
                } else {
                    // write update query
                    // in this case, it seemed like we have so many fields to pass and
                    // it is better to label them and not use question marks
                    $query = "UPDATE Customers
                        SET Password=:Password, FirstName=:FirstName, cPassword=:cPassword, oPassword=:oPassword, LastName=:LastName, Gender=:Gender, dob=:dob WHERE Username = :Username";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':Username', $Username);
                    //$stmt->bindParam(':oPassword', $oPassword);
                    $newpass = md5($Password);
                    $stmt->bindParam(':Password', $newpass);
                    $stmt->bindParam(':FirstName', $FirstName);
                    $stmt->bindParam(':LastName', $LastName);
                    $stmt->bindParam(':Gender', $Gender);
                    $stmt->bindParam(':dob', $dob);

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
        }
        ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?Username={$Username}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($Username, ENT_QUOTES);  ?> </td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type='text' name='oPassword' value="" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='Password' value="" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Comfirm Password</td>
                    <td><input type='text' name='cPassword' value="" class='form-control' /></td>
                </tr>
                <tr>
                    <td>FirstName</td>
                    <td><input type='text' name='FirstName' value="<?php echo htmlspecialchars($FirstName, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>LastName</td>
                    <td><input type='text' name='LastName' value="<?php echo htmlspecialchars($LastName, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type='radio' id='Male' name='Gender' value='1' <?php if (isset($Gender) && $Gender == "1") echo "checked" ?> />
                        <label for='Male'>Male</label>
                        <input type='radio' id='Female' name='Gender' value='0' <?php if (isset($Gender) && $Gender == "0") echo "checked" ?> />
                        <label for='Female'>Female</label>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='dob' value="<?php echo htmlspecialchars($dob, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='readCustomers.php' class='btn btn-danger'>Back to read Customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
</body>

</html>