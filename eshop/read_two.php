<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
 
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Customer</h1>
        </div>
         
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$Username=isset($_GET['Username']) ? $_GET['Username'] : die('ERROR: Record Username not found.');
 
//include database connection
include 'config/database.php';
 
// read current record's data
try {
    // prepare select query
    $query = "SELECT Username, Password, FirstName, LastName, Gender, dob FROM customers WHERE id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
 
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
    $dob = $row['Birthday'];
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

 
        <!--we have our html table here where the record will be displayed-->
<table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Username</td>
        <td><?php echo htmlspecialchars($Username, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><?php echo htmlspecialchars($Password, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>FirstName</td>
        <td><?php echo htmlspecialchars($FirstName, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>LastName</td>
        <td><?php echo htmlspecialchars($LastName, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Gender</td>
        <td><?php echo htmlspecialchars($Gender, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Birthday</td>
        <td><?php echo htmlspecialchars($dob, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <a href='readCustomers.php' class='btn btn-danger'>Back to read</a>
        </td>
    </tr>
</table>

 
    </div> <!-- end .container -->
 
</body>
</html>