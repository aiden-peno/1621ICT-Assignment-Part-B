<?php
    require_once('./db/queryDb.php');

    // set this to true after user is created
    $showSuccessMessage = false;

    $userLoggedIn = false;
    // check user is logged in - we serve different html if they are
    $userLoggedIn = isset($_COOKIE["user"]);

    // handle submitted form
    if (isset($_POST["first_name"])) {
        // see if user already exists via entered email
        $alreadyExists = checkUserExists($_POST["email"]);
        if (!$alreadyExists) {
            // add user to DB
            $result = addUser($_POST["first_name"], $_POST["last_name"], $_POST["gender"], $_POST["dob"], $_POST["team"], $_POST["phone"], $_POST["email"], $_POST["street_address"], $_POST["suburb"], $_POST["postcode"], $_POST["state"], $_POST["birth_country"], $_POST["nationality"], $_POST["disability"], $_POST["cultural_origin"], $_POST["english_spoken_language"], $_POST["spoken_language"], $_POST["emergency_name"], $_POST["emergency_phone"], $_POST["emergency_email"], $_POST["confirm-password"]);

            // result is false if failed, otherwise blank array
            if ($result != false) {
                // set user in cookies
                setcookie("user", $_POST["email"], 0);
                $showSuccessMessage = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Join the Club - Dolphins Touch Football Club</title>
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' href='./css/styles.css' />
    <script src="./scripts/base.js"></script>
    <!--Font for mobile navigation icons-->
    <script src="https://kit.fontawesome.com/86459535c0.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <script>
        // once DOM loads, populate dropdowns as needed
        window.addEventListener('DOMContentLoaded', (event) => {
            populateJoinSelects();
        });
    </script>
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
            <h1>Join the DTFC Family</h1>
        </section>
    </header>
    <!-- <div id='main' class="center-content"> -->
    <div id='main'>
        <?php
            if ($showSuccessMessage) {
        ?>
        <section id="user-created-section">
            <h2>User created successfully!</h2>
            <p>You can now login from the <a href="./account.php">Account page</a>.</p>
        </section>
        <?php 
            } else {
                if (!$userLoggedIn) {
        ?>
        <section id="join-form-section">
            <h2>Complete Form to Join</h2>
            <form id="join-form" action="join.php" method="POST" onsubmit="return verifyPassword()">
                <fieldset>
                    <legend>Basic Details</legend>
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" maxlength="20" required />
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" maxlength="20" required />
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value=""></option>
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                        <option value="Non-binary">Non-binary</option>
                    </select>
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required />
                    <label for="team">Select The Team You Wish To Join</label>
                    <select id="team" name="team" required>
                        <option value=""></option>
                        <option value="Under 15 Mixed">Under 15 Mixed</option>
                        <option value="Under 16 Mixed">Under 16 Mixed</option>
                        <option value="Under 17 Mixed">Under 17 Mixed</option>
                        <option value="Senior Mixed">Senior Mixed</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legend>Contact Details</legend>
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" maxlength="20" required />
                    <p id="email-valid-p" class="field-valid-message"></p>
                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" maxlength="100" required onBlur="checkEmailExists()"/>
                    <label for="street_address">Street Address</label>
                    <input type="text" id="street_address" name="street_address" maxlength="100" required />
                    <label for="suburb">Suburb</label>
                    <input type="text" id="suburb" name="suburb" maxlength="50" required />
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" maxlength="4" pattern="[0-9]*" required />
                    <label for="state">State</label>
                    <select id="state" name="state" required>
                        <option value=""></option>
                        <option value="Queensland">Queensland</option>
                        <option value="Australian Capital Territory">Australian Capital Territory</option>
                        <option value="New South Wales">New South Wales</option>
                        <option value="Northern Territory">Northern Territory</option>
                        <option value="South Australia">South Australia</option>
                        <option value="Tasmania">Tasmania</option>
                        <option value="Victoria">Victoria</option>
                        <option value="Western Australia">Western Australia</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legend>Cultural Details</legend>
                    <label for="birth_country">Country of Birth</label>
                    <select id="birth_country" name="birth_country" required>
                        <option value=""></option>
                        <option value="Australia">Australia</option>
                    </select>
                    <label for="nationality">Nationality</label>
                    <select id="nationality" name="nationality" required>
                        <option value=""></option>
                        <option value="Australian">Australian</option>
                    </select>
                    <label for="disability">Enter any Disability Information</label>
                    <input type="text" id="disability" name="disability" maxlength="200"/>
                    <label for="cultural_origin">Aborinal/Torres Strait Islander Origin</label>
                    <section class="radio-section">
                        <input type="radio" id="aboriginal" value="Aboriginal" name="cultural_origin" required />
                        <label for="aboriginal" class="radio_label">Aboriginal</label>
                    </section>
                    <section class="radio-section">
                        <input type="radio" id="tores_strait" value="Torres Strait Islander" name="cultural_origin" />
                        <label for="tores_strait" class="radio_label">Torres Strait Islander</label>
                    </section>
                    <section class="radio-section">
                        <input type="radio" id="cultural_none" value="None" name="cultural_origin" />
                        <label for="cultural_none" class="radio_label">None</label>
                    </section>

                    <label for=english_spoken_language>Is English Your Primary Spoken Language</label>
                    <select id="english_spoken_language" name="english_spoken_language" required onchange="toggleSpokenLanguage()">
                        <option value=""></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                    <label for="spoken_language" id="spoken-language-label" class="display-none">Language Other Than English</label>
                    <select id="spoken_language" name="spoken_language" class="display-none">
                        <option value=""></option>
                    </select>
                </fieldset>
                <fieldset>
                    <legend>Emergency Contact</legend>
                    <label for="emergency_name">Emergency Contact - Name</label>
                    <input type="text" id="emergency_name" name="emergency_name" required />
                    <label for="emergency_phone">Emergency Contact - Number</label>
                    <input type="text" id="emergency_phone" name="emergency_phone" required />
                    <label for="emergency_email">Emergency Contact - Email</label>
                    <input type="text" id="emergency_email" name="emergency_email" required />
                </fieldset>
                <fieldset>
                    <legend>Set Password</legend>
                    <p id="password-valid-p" class="field-valid-message"></p>
                    <label for="password">Account Password</label>
                    <input type="password" id="password" name="password" maxlength="1000" required />
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" maxlength="1000" required />
                    <input type="submit" id="submit-button" value="Submit" />
                </fieldset>
            </form>
        </section>
        <?php
                } else {
        ?>
        <section id="logged-in-section">
            <h2>You're already part of the club!</h2>
            <p>We're redirecting you to the account page</p>
            <script>
                // wait for specified time then redirect to account.php
                setTimeout(function () {
                    window.location.replace("./account.php");
                }, 3000);
            </script>
        </section>
        <?php
                }
            }
        ?>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>