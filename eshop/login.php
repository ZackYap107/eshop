<!DOCTYPE HTML>
<html>

<head>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
        <?php
        include 'config/database.php';

        $Username = "Username";
        $Password = "Password";

        if (isset($Username)) {
            $query = "SELECT Username, Password FROM customer where Username = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $Username);
            //$stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($row);
            if (is_array($row)) {
                if ($Password == $row['Password']) {
                    echo "Login Succuessful";
                } else {
                    echo "wrong password";
                }
            } else {
                echo "User not found";
            }
        }

        ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>