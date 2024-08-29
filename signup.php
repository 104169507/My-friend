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
        <p class="caption">Fill in the form to sign up to the system</p>
        <div class="main-content">
            <form action="signup.php" method="post">
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
                            if (mysqli_num_rows($result1) > 0) {
                                echo "<div class='invalid-feedback d-block'>";
                                echo "Email must be a valid email format and not exists in the 'friends' table";
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
                            echo "Email must be a valid email format and not exists in the 'friends' table";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="name">Profile Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo isset ($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    <?php
                    //process the profile name field and check for errors
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset ($_POST['name']) && preg_match("/^[A-Za-z]+$/", $_POST['name'])) {
                            $name = addslashes(trim($_POST['name']));
                            if ($loggedIn == true)
                                $loggedIn = true;
                            echo "<div class='valid-feedback d-block'>";
                            echo "Valid profile name";
                            echo "</div>";
                        } else {
                            $loggedIn = false;
                            echo "<div class='invalid-feedback d-block'>";
                            echo "Profile must contain only letters and cannot be blank";
                            echo "</div>";
                        }
                    }
                    ?>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php
                    //process the password field and check for errors
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset ($_POST['password']) && preg_match("/^[A-Za-z0-9]+$/", $_POST['password'])) {
                            $password = addslashes(trim($_POST['password']));
                            if ($loggedIn == true)
                                $loggedIn = true;
                            echo "<div class='valid-feedback d-block'>";
                            echo "Valid password";
                            echo "</div>";
                        } else {
                            $loggedIn = false;
                            echo "<div class='invalid-feedback d-block'>";
                            echo "Password must contain only letters and numbers";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="password2">Confirm Password</label>
                    <input type="password" class="form-control" id="password2" name="password2">
                    <?php
                    //check if this field has the same value as the password
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if (isset ($_POST['password2']) && preg_match("/^[A-Za-z0-9]+$/", $_POST['password']) && (addslashes(trim($_POST['password2']))) === (addslashes(trim($_POST['password'])))) {
                            $password2 = addslashes(trim($_POST['password2']));
                            if ($loggedIn == true)
                                $loggedIn = true;
                            echo "<div class='valid-feedback d-block'>";
                            echo "Valid password";
                            echo "</div>";
                        } else {
                            $loggedIn = false;
                            echo "<div class='invalid-feedback d-block'>";
                            echo "Passwords do not match";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-success btn-block">Register</button>
                    <a href="signup.php" class="btn btn-outline-danger btn-block">Clear</a>
                </div>
            </form>
        </div>
        <?php
        if ($loggedIn) {
            //save every information into the database and set the time as the current time
            date_default_timezone_set('Vietnam/Hanoi');
            $date = date('Y-m-d', time());
            $query = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends) VALUES ('$email', '$password', '$name', '$date', 0)";
            $result = mysqli_query($conn, $query);
            if (!$result1) {
                error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
                echo "<p>Something went wrong with the friends table. Please try again later.</p>";
            }
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['loggedIn'] = true;
            mysqli_close($conn);
            header("Location: friendadd.php");
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