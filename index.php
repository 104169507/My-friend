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
    <title>Home Page</title>
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
        <p class="caption">Assignment Home Page</p>
        <div class="main-content">
            <p>Name: Nguyen Quang Huy</p>
            <p>Student ID: 104169507</p>
            <p>Email: 104169507@student.swin.edu.au</p>
            <p>I declare that this assignment is my individual work. I have not worked collaboratively, nor have I
                copied from any other student&apos;s work or from any other source</p>
        </div>
        <?php
        require_once ("functions/settings.php");

        $conn = @mysqli_connect($host, $user, $pswd, $dbnm);
        $query1 = "CREATE TABLE IF NOT EXISTS friends (
        friend_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        friend_email VARCHAR(50) NOT NULL,
        password VARCHAR(20) NOT NULL,
        profile_name VARCHAR(30) NOT NULL,
        date_started DATE NOT NULL,
        num_of_friends INT UNSIGNED
        )";

        $result1 = mysqli_query($conn, $query1);
        if (!$result1) {
            error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
            echo "<p>Something went wrong with the friends table. Please try again later.</p>";
        }


        // Create table myfriends if not exists and check if 2 ids are differences
        $query2 = "
        CREATE TABLE IF NOT EXISTS myfriends (
            friend_id1 INT NOT NULL,
            friend_id2 INT NOT NULL,
            CONSTRAINT chk_friend_ids CHECK (friend_id1 != friend_id2)
        )";

        $result2 = mysqli_query($conn, $query2);
        if (!$result2) {
            error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
            echo "<p>Something went wrong with myfriends table. Please try again later.</p>";
        }

        // Check if table friends is empty
        $query3 = "SELECT * FROM friends";
        $result3 = mysqli_query($conn, $query3);
        if (mysqli_num_rows($result3) == 0) {
            // Insert sample data to table "friends"
            $query4 = "INSERT INTO friends (friend_id, friend_email, password, profile_name, date_started, num_of_friends)
            VALUES
            (1, 'john@example.com', 'john123', 'John Doe', '2022-01-01', 4),
            (2, 'jane@example.com', 'jane123', 'Jane Doe', '2022-02-01', 4),
            (3, 'bob@example.com', 'bob123', 'Bob Smith', '2022-03-01', 4),
            (4, 'alice@example.com', 'alice123', 'Alice Johnson', '2022-04-01', 4),
            (5, 'charlie@example.com', 'charlie123', 'Charlie Brown', '2022-05-01', 4),
            (6, 'david@example.com', 'david123', 'David Davis', '2022-06-01', 4),
            (7, 'emma@example.com', 'emma123', 'Emma Watson', '2022-07-01', 4),
            (8, 'frank@example.com', 'frank123', 'Frank Sinatra', '2022-08-01', 4),
            (9, 'grace@example.com', 'grace123', 'Grace Hopper', '2022-09-01', 4),
            (10, 'harry@example.com', 'harry123', 'Harry Potter', '2022-10-01', 4);";

            $result4 = mysqli_query($conn, $query4);
            // Execute the query and check for any errors
            if (!$result4) {
                error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
                echo "<p>Something went wrong. Please try again later.</p>";
            }
        }

        // Check if table myfriends is empty
        $query5 = "SELECT * FROM myfriends";
        $result5 = mysqli_query($conn, $query5);
        if (mysqli_num_rows($result5) == 0) {
            // Insert sample data to table "myfriends"
            $query6 = "INSERT INTO myfriends (friend_id1, friend_id2)
    VALUES
      (1, 2),
      (2, 3),
      (3, 4),
      (4, 5),
      (5, 6),
      (6, 7),
      (7, 8),
      (8, 9),
      (9, 10),
      (10, 1),
      (1, 3),
      (2, 4),
      (3, 5),
      (4, 6),
      (5, 7),
      (6, 8),
      (7, 9),
      (8, 10),
      (9, 1),
      (10, 2)";

            // Execute the query and check for any errors
            $result6 = mysqli_query($conn, $query6);
            // Execute the query and check for any errors
            if (!$result6) {
                error_log("Unable to execute the query. Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn));
                echo "<p>Something went wrong. Please try again later.</p>";
            }
        }

        // Close connection
        mysqli_close($conn);
        echo "<p style = 'color: green;'><i>Tables successfully created and populated.</i></p>";
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