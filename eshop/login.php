<!DOCTYPE HTML>
<html>

<head>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Login</title>

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

</head>

<body class="text-center row">

    <?php
    if ($_POST) {

        $Username = htmlspecialchars(strip_tags($_POST['Username']));
        $Password = htmlspecialchars(strip_tags($_POST['Password']));
        //$Password = md5($_POST['Password']);

        if ($Username == "") {
            echo "<div class='alert alert-danger row justify-content-center'>Please Fill in all Information</div>";
        } else {

            include 'config/database.php';
            try {

                //get POST Value

                if (isset($Username)) {
                    $query = "SELECT Username, Password, AccountStatus FROM customers where Username = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(1, $Username);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    //var_dump($row);
                    if (is_array($row)) {
                        if (md5($Password) == $row['Password']) {
                            if ($row['AccountStatus'] == 1) {
                                header("Location: readCustomers.php");
                                exit();
                            } else {
                                echo "<div class='alert alert-danger row justify-content-center'>Not active Account</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger row justify-content-center'>wrong password</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger row justify-content-center'>User not found</div>";
                    }
                }
            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
    }
    ?>

    <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <img class="mb-4" src="store_logo.jpg" alt="logo">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="username" class="form-control" name="Username" placeholder="Username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="Password" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <input type="submit" class="w-100 btn btn-lg btn-primary" value="Login">
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>