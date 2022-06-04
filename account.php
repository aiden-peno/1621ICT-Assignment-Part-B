<?php
require_once('./db/queryDb.php');

// check user is logged in - used to serve different html if they are
$userLoggedin = isset($_COOKIE["user"]);

if ($userLoggedin) {
    $userInformation = getUser($_COOKIE["user"]);
    // will only be one entry, store 0th index to array so don't need to keep referencing it
    $userInformation = $userInformation[0];

    //if logout clicked
    if (isset($_POST["logout"])) {
        // clear user session
        unset($_COOKIE["user"]);
        setcookie("user");
        // Refresh after clearing user - also prevents sending same request on browser refresh 
        Header('Location: ' . $_SERVER['PHP_SELF']);
    }
}

// set failed login flag false - if true, used to display login error message
$failedLogin = false;

if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // check entered credentials exist in DB
    $validEmail = validateUser($username, $password);

    if (count($validEmail) > 0) {
        $failedLogin = false;
        // log user in - set user details in cookies
        setcookie("user", $username, 0);
        // clear userInformation array
        $userInformation = [];
        // Refresh after setting user to display new HTML - also prevents sending same request on browser refresh 
        Header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        $failedLogin = true;
    }
}

if (isset($_POST["first-name"])) {
    $fname = trim($_POST["first-name"]);
    $lname = trim($_POST["last-name"]);
    $phone = trim($_POST["phone-number"]);
    $email = $userInformation["EMAIL"];

    if ($fname != "" || $lname != "" || $phone != "") {
        updateUser($fname, $lname, $phone, $email);
        Header('Location: ' . $_SERVER['PHP_SELF']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account - Dolphins Touch Football Club</title>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./css/styles.css' />
    <script src="./scripts/base.js"></script>
    <!--Font for mobile navigation icons-->
    <script src="https://kit.fontawesome.com/86459535c0.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php
    // Populate the Email and Password fields with last entered details if login attempt failed.
    // Doing this with Javascript as I have the test credentials entered by default.
    if (isset($username) && $username != "") {
    ?>
        <script>
            // wait for document to load to allow overwriting of the default value specified in the html
            window.onload = function() {
                document.getElementById("username").value = "<?= $username ?>";
                document.getElementById("password").value = "<?= $password ?>";
            }
        </script>
    <?php
    }
    ?>
</head>

<body>
    <header id="header">
        <div id='top-header'>
            <a id='logo' href='./index.html'><img src="images/dolphins_logo.svg" alt="Dolphin" />
                DTFC</a>
            <a href='javascript:void(0);' onclick='expandHamburgerMenu()'>
                <i id="nav-toggle-button" class='fa-solid fa-bars hamburger-icon'></i>
            </a>
            <nav id="nav-links">
                <ul>
                    <li><a href='./teams.php'>Teams</a></li>
                    <li><a href='./join.php'>Join</a></li>
                    <li><a href='./draw.php'>Draw</a></li>
                    <li><a href='./standings.php'>Standings</a></li>
                    <li><a href='./community.php'>Community</a></li>
                    <li><a href='./contact.php'>Contact</a></li>
                    <li><a href='./account.php'>Account</a></li>
                </ul>
            </nav>
        </div>
        <section id="page-title">
            <h1>Your Account</h1>
        </section>
    </header>
    <?php
    if ($userLoggedin) {
    ?>
        <div id='main'>
            <section id="user-details-section">
                <h2>Basic Details</h2>
                <section id="account-basic-details" class="account-details-section">
                    <h2 class="display-none">Basic Details</h2>
                    <div id="basic-details-div">
                        <p>Name: <?php echo $userInformation["FIRST_NAME"] . " " . $userInformation["LAST_NAME"] ?></p>
                        <p>Phone Number: <?= $userInformation["PHONE"] ?></p>
                        <p>Email: <?= $userInformation["EMAIL"] ?></p>
                    </div>
                    <a id="basic-details-update-link" href='javascript:void(0);' onclick='toggleAndResetDetailsForm()'>Update Details</a>
                    <form id="basic-details-form" class="display-none" action="account.php" method="POST">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first-name" value="<?=$userInformation["FIRST_NAME"]?>" required />
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last-name" value="<?=$userInformation["LAST_NAME"]?>" required />
                        <label for="phone-number">Phone Number</label>
                        <input type="text" id="phone-number" name="phone-number" value="<?=$userInformation["PHONE"]?>" required />
                        <input type="submit" value="Submit" />
                        <input type="reset" value="Cancel" onclick="toggleAndResetDetailsForm(this)" />
                    </form>
                </section>
                <h2>Other Details</h2>
                <section class="account-details-section">
                    <h2 class="display-none">Other Details</h2>
                    <p>Team: <?= $userInformation["TEAM"] ?></p>
                    <p>Address: <?php echo $userInformation["ADDRESS_STREET"] . ", " . $userInformation["ADDRESS_SUBURB"] . ", " . $userInformation["ADDRESS_STATE"] . ", " . $userInformation["ADDRESS_POSTCODE"] ?></p>
                    <p>Country of Birth: <?= $userInformation["BIRTH_COUNTRY"] ?></p>
                    <p>Nationality: <?= $userInformation["NATIONALITY"] ?></p>
                    <p>Disability: <?= $userInformation["DISABILITY"] ?></p>
                    <p>Cultural Origin: <?= $userInformation["CULTURAL_ORIGIN"] ?></p>
                    <p>Primary Spoken Language English: <?= $userInformation["ENGLISH_PRIMARY"] ?></p>
                    <?php if ($userInformation["ENGLISH_PRIMARY"] != "Yes") { ?>
                        <p>Primary Spoken Language: <?= $userInformation["LOTE"] ?></p>
                    <?php } ?>
                </section>
                <h2>Emergency Contact Details</h2>
                <section class="account-details-section">
                    <h2 class="display-none">Emergency Contact Details</h2>
                    <p>Name: <?= $userInformation["EMERGENCY_NAME"] ?></p>
                    <p>Phone: <?= $userInformation["EMERGENCY_PHONE"] ?></p>
                    <p>Email: <?= $userInformation["EMERGENCY_EMAIL"] ?></p>
                </section>
                <form action="./account.php" method="POST">
                    <input type="hidden" id="logout" name="logout" value="logout" />
                    <input type="submit" value="Logout" />
                </form>
            </section>
        </div>
    <?php
    } else {
    ?>
        <div id='main' class="center-content">
            <section id="login-section">
                <h2>Please Log In</h2>
                <?php
                if ($failedLogin) {
                ?>
                    <p id="user-valid-p">Email and password do not match, please try again.</p>
                <?php
                }
                ?>
                <form action="account.php" method="POST">
                    <label for="username">Email</label>
                    <input type="text" id="username" name="username" value="test@testemail.com" required />
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="1234" required />
                    <input type="submit" value="Login" />
                </form>
            </section>
        </div>
    <?php
    }
    ?>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>