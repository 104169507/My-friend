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
    <title>About Page</title>
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
        <p class="caption">About this assignment</p>
        <div class="main-content">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> I have attempted to finish all
                    the given tasks.</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> In addition to the requirement
                    of the task, I have also implement the pagination for both addfriend and listfriend page. Beside
                    that, I spent a considerate amount of time to style the page.</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> During this assignment, I had
                    some troubles with the mutual friend count during the coding process. However, I had change some of
                    the logics in the code and made it work.</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> If I had a chance to redo this
                    assignment, I would definitely start coding earlier and spend more time testing it.</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> I have added extra pagination
                    to friendlist page and added the check to guild the user back to log in page if the access the
                    friendlist and friendadd without permission.</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> Here is the link to <a
                        href="friendlist.php">Friend List</a>, <a href="friendadd.php">Friend Add</a> ,<a
                        href="index.php">Home Page</a> .</li>
                <li class="list-group-item"><i class="fa-solid fa-lightbulb fa-2xs"></i> I have tried to respond to this
                    discussion on Canvas. Moreover, I have been actively helping other classmates
                    during the discussion time in class. <img src="images/discussion.png" class="img-thumbnail" alt="discussion"></li>
            </ul>
        </div>
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