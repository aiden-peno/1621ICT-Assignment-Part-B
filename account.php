<?php
    require_once('./db/queryDb.php');

    // check user is logged in - serve different html if they are
    $userLoggedin = isset($_COOKIE["user"]);

    if($userLoggedin) {
        $userInformation = getUser($_COOKIE["user"]);
        // will only be one entry, store 0th index to array so don't need to keep referencing it
        $userInformation = $userInformation[0];

        if(isset($_POST["logout"])) {
            // clear user session
            unset($_COOKIE["user"]); 
            setcookie("user");
            // Refresh after clearing user
            Header('Location: '.$_SERVER['PHP_SELF']);
        }
    }

    // set failed login flag false - if true, displays login error message
    $failedLogin = false;

    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $validEmail = validateUser($username, $password);

        if (count($validEmail) > 0) {
            $failedLogin = false;

            // log user in
            // set user details in cookies
            setcookie("user", $username, 0);
            // Refresh after setting user
            Header('Location: '.$_SERVER['PHP_SELF']);
        } else {
            $failedLogin = true;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account - Dolphins Touch Football Club</title>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./css/styles.css' />
    <script src="./scripts/base.js"></script>
    <!--Font for mobile navigation icons-->
    <script src="https://kit.fontawesome.com/86459535c0.js" crossorigin="anonymous"></script>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
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
    if($userLoggedin) {
    // if(false) {
?>
    <div id='main'>
        <section id="user-details-section">
            <h2>Basic Details</h2>
            <section id="account-basic-details" class="account-details-section">
                <div>
                    <p>Name: <?php echo $userInformation["FIRST_NAME"] . " " . $userInformation["LAST_NAME"] ?></p>
                    <p>Phone Number: <?=$userInformation["PHONE"]?></p>
                    <p>Email: <?=$userInformation["EMAIL"]?></p>
                </div>
                <a>Update Details</a>
            </section>
            <h2>Other Details</h2>
            <section class="account-details-section">
                <p>Team: <?=$userInformation["TEAM"]?></p>
                <p>Address: <?php echo $userInformation["ADDRESS_STREET"] . ", " . $userInformation["ADDRESS_SUBURB"] . ", " . $userInformation["ADDRESS_STATE"] . ", " . $userInformation["ADDRESS_POSTCODE"] ?></p>
                <p>Country of Birth: <?=$userInformation["BIRTH_COUNTRY"]?></p>
                <p>Nationality: <?=$userInformation["NATIONALITY"]?></p>
                <p>Disability: <?=$userInformation["DISABILITY"]?></p>
                <p>Cultural Origin: <?=$userInformation["CULTURAL_ORIGIN"]?></p>
                <p>Primary Spoken Language English: <?=$userInformation["ENGLISH_PRIMARY"]?></p>
                <?php if ($userInformation["ENGLISH_PRIMARY"] != "Yes") {?>
                <p>Primary Spoken Language: <?=$userInformation["LOTE"]?></p>
                <?php }?>
            </section>
            <h2>Emergency Contact Details</h2>
            <section class="account-details-section">
                <p>Name: <?=$userInformation["EMERGENCY_NAME"]?></p>
                <p>Phone: <?=$userInformation["EMERGENCY_PHONE"]?></p>
                <p>Email: <?=$userInformation["EMERGENCY_EMAIL"]?></p>
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
                <!-- <input type="text" id="username" name="username" <?php if(isset($_POST["username"])) { echo "value='" . $_POST['username'] . "'"; } ?> required/> -->
                <input type="text" id="username" name="username" required/>
                <label for="password">Password</label>
                <!-- <input type="password" id="password" name="password" <?php if(isset($_POST["password"])) { echo "value='" . $_POST['password'] . "'"; } ?> required/> -->
                <input type="password" id="password" name="password" required/>
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

