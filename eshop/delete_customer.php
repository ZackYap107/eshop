<?php
// include database connection
include 'config/database.php';
try {
    // get record Username
    // isset() is a PHP function used to verify if a value is there or not
    $Username = isset($_GET['Username']) ? $_GET['Username'] :  die('ERROR: Record Username not found.');

    $query = "SELECT * FROM orders WHERE customer = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $Username);
    $stmt->execute();
    $row = $stmt->rowCount();
    if ($row > 0) {
        header('Location: readCustomers.php?action=notdeleted');
    } else {

        // delete query
        $query = "DELETE FROM customers WHERE Username = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $Username);

        if ($stmt->execute()) {
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: readCustomers.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }
    }
}
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>