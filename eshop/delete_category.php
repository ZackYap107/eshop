<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $query = "SELECT * FROM products WHERE category = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $row = $stmt->rowCount();
    if($row > 0)
    {
        header('Location: categories_list.php?action=notdeleted');
    }else{
        
        // delete query
        
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()){
            // redirect to read records page and
            // tell the user record was deleted
            header('Location: categories_list.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }

    
}
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}

?>