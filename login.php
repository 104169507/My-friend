<?php
//this variable used to keep track of the current state of the user
$loggedIn = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Nguyen Quang Huy">
    <meta name="description" content="Index page">
    <meta name="keywords" content="Home page">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f73039f1ad.js" crossorigin="anonymous"></script>
    <title>Sign Up</title>
</head>

<body>
    <header>
        <!-- Navigation bar -->
        <nav class="topmenu" id="navbar">
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="signup.php">Sign up</a>
                </li>
                <li><a href="login.php">Log in</a></li>
                <li>
                    <a href="about.php">About</a>
                </li>
            </ul>
        </nav>
    </header>
    <section class="container">
        <h1>My Friend System</h1>
        <p class="caption">Fill in the form to log in to the system</p>
        <div class="main-content">
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="<?php echo isset ($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <?php
                    //process the email field and check for errors
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset ($_POST['email']) && preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['email'])) {
                            require_once ("functions/settings.php");
                            $email = addslashes(trim($_POST['email']));
                            $conn = @mysqli_connect($host, $user, $pswd, $dbnm);
                            $query1 = "SELECT friend_email FROM friends WHERE friend_email = '$email'";
                            $result1 = mysqli_query($conn, $query1);
                            if (mysqli_num_rows($result1) == 0) {
                                echo "<div class='invalid-feedback d-block'>";
                                echo "Email must exists in the 'friends' table";
                                echo "</div>";
                            } else {
                                $loggedIn = true;
                                echo "<div class='valid-feedback d-block'>";
                                echo "Valid email address";
                                echo "</div>";
                            }
                            if (!$result1) {
                                error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
                                echo "<p>Something went wrong with the friends table. Please try again later.</p>";
                            }
                        } else {
                            echo "<div class='invalid-feedback d-block'>";
                            echo "Email must exists in the 'friends' table";
                            echo "</div>";
                        }
                    }
                    ?>
                    <div class="form-group">
                        <label for="email">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <?php
                        //process the password field and check for errors
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (isset ($_POST['password']) && preg_match("/^[A-Za-z0-9]+$/", $_POST['password']) && isset($email)) {
                                $password = addslashes(trim($_POST['password']));
                                $conn = @mysqli_connect($host, $user, $pswd, $dbnm);
                                $query = "SELECT password FROM friends WHERE password = '$password' AND friend_email = '$email'";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) == 0) {
                                    echo "<div class='invalid-feedback d-block'>";
                                    echo "Wrong password";
                                    echo "</div>";
                                    $loggedIn = false;
                                } else {
                                    if ($loggedIn == true)
                                        $loggedIn = true;
                                    echo "<div class='valid-feedback d-block'>";
                                    echo "Valid password";
                                    echo "</div>";
                                }
                                if (!$result) {
                                    error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
                                    echo "<p>Something went wrong with the friends table. Please try again later.</p>";
                                }
                            } else {
                                $loggedIn = false;
                                echo "<div class='invalid-feedback d-block'>";
                                echo "Wrong password";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-success btn-block">Login</button>
                        <a href="login.php" class="btn btn-outline-danger btn-block">Clear</a>
                    </div>
            </form>
        </div>
        <?php
        if ($loggedIn) {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['loggedIn'] = true;
            header("Location: friendlist.php");
        }
        ?>
    </section>

    <footer id="footer">
        <h2>Assignment 2 - COS30020 - My Friend System</h2>
        <h3>Sitemap</h3>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="signup.php">Sign up</a></li>
            <li><a href="login.php">Log in</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
        <h3>Contact</h3>
        <ul>
            <li><a href="https://www.facebook.com"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/?lang=en"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com"><i class="fa-brands fa-instagram"></i></a></li>
        </ul>
        <p>
            &#169; Copyright Nguyen Quang Huy 2024
        </p>
    </footer>
</body>

</html>