<?php
session_start();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true) {
    header("Location: login.php");
    exit();
}
$email = $_SESSION["email"];
require_once ("functions/settings.php");
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);

//Get the total of friends from the table to check if the friendadd id is valid?
$query = "SELECT COUNT(*) FROM friends";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_row($result);
$max_id = $row[0];

//Get the id of the current user
$query = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_email = '$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$friendId = $row["friend_id"];

//Add the friend to the myfriends table and update 
if (isset($_GET["addf_id"]) && is_numeric($_GET["addf_id"]) && $_GET["addf_id"] <= $max_id) {
    $query = "SELECT friend_id1 FROM myfriends WHERE (friend_id1 = " . $friendId . " AND friend_id2 = " . $_GET["addf_id"] . ") 
    OR (friend_id2 = " . $friendId . " AND friend_id1 = " . $_GET["addf_id"] . ")";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES (" . $friendId . ", " . $_GET["addf_id"] . ")";
        $result = mysqli_query($conn, $query);
        $query = "UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = " . $friendId;
        $result = mysqli_query($conn, $query);
        $query = "UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = " . $_GET["addf_id"];
        $result = mysqli_query($conn, $query);
    }
}

// Query the result for profile name and number of friends
$query = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_email = '$email'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$name = $row["profile_name"];
$num_of_friends = $row["num_of_friends"];

// Get the list of non-friends of the logged in user
$query = "
SELECT friend_id, friend_email, profile_name FROM friends 
WHERE friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = " . $friendId . ") 
AND friend_id NOT IN (SELECT friend_id1 FROM myfriends WHERE friend_id2 = " . $friendId . ") 
AND friend_id != " . $friendId;
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

//set up the pagination
$page = 1;
$max_page = ceil($num / 5.0);
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = (int) $_GET["page"];
}
if ($page > $max_page)
    $page = $max_page;
if ($page < 1)
    $page = 1;

//save all the friends'id in the my friend list
$myfriends = array();
$query = "SELECT friend_id2 AS friend_id FROM myfriends WHERE friend_id1 = $friendId";
$res = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($res)) {
    $myfriends[] = $row["friend_id"];
}
$query = "SELECT friend_id1 AS friend_id FROM myfriends WHERE friend_id2 = $friendId";
while ($row = mysqli_fetch_assoc($res)) {
    $myfriends[] = $row["friend_id"];
}

// Get non-friends in paginated form
$query = "SELECT friend_id, friend_email, profile_name FROM friends
        WHERE friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = " . $friendId . ")
        AND friend_id NOT IN (SELECT friend_id1 FROM myfriends WHERE friend_id2 = " . $friendId . ")
        AND friend_id != " . $friendId . "
        LIMIT 5
        OFFSET " . ($page - 1) * 5;
$result = mysqli_query($conn, $query);
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
    <title>Friend list</title>
</head>

<body>
    <header>
        <!-- Navigation bar -->
        <nav class="topmenu" id="navbar">
            <ul>
                <li>
                    <a href="friendlist.php">Friend list</a>
                </li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </nav>
    </header>
    <section class="container">

        <h1>
            <?php echo $name ?>'s Add Friend Page
        </h1>
        <p class="caption">You now have
            <?php echo $num_of_friends ?> friends.
        </p>
        <div class='row pb-5'>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($friends = mysqli_fetch_assoc($result)) {

                    //get all the ids of this person and save it inside an array to compare it with the friends of the user
                    $guestfriends = array();
                    $query = "SELECT friend_id2 AS friend_id FROM myfriends WHERE friend_id1 = " . $friends['friend_id'];
                    $res = mysqli_query($conn, $query);
                    while ($r = mysqli_fetch_assoc($res)) {
                        $guestfriends[] = $r["friend_id"];
                    }
                    $query = "SELECT friend_id1 AS friend_id FROM myfriends WHERE friend_id2 = " . $friends['friend_id'];
                    $res = mysqli_query($conn, $query);
                    while ($r = mysqli_fetch_assoc($res)) {
                        $guestfriends[] = $r["friend_id"];
                    }
                    $mutualfriend = 0;
                    foreach ($myfriends as $myfriend) {
                        foreach ($guestfriends as $guestfriend) {
                            if ($myfriend == $guestfriend)
                                $mutualfriend++;
                        }
                    }

                    echo "<div class='col-4'>
                            <div class='card m-1'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . $friends["profile_name"] . "</h5>
                                    <p class='card-text'>Mutual friends: " . $mutualfriend . "</p>
                                        <a href='friendadd.php?addf_id=" . $friends['friend_id'] . "'class='btn btn-outline-success'>Add friend</a>
                                </div>
                            </div>
                        </div>";
                }
            }
            ?>
        </div>
        <nav aria-label="friend add navigation">
            <ul class="pagination justify-content-center">
                <?php
                if ($page > 1) {
                    echo "<li class='page-item'><a class='page-link' href='friendadd.php?page=", $page - 1, "'>Previous</a></li>";
                }
                if ($page < $max_page) {
                    echo "<li class='page-item'><a class='page-link' href='friendadd.php?page=", $page + 1, "'>Next</a></li>";
                }
                ?>
            </ul>
        </nav>
    </section>

    <footer id="footer">
        <h2>Assignment 2 - COS30020 - My Friend System</h2>
        <h3>Sitemap</h3>
        <ul>
            <li>
                <a href="listfriend.php">List friend</a>
            </li>
            <li><a href="logout.php">Log out</a></li>
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