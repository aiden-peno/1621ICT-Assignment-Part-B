<?php
require_once('./db/queryDb.php');

if (isset($_GET["draw-filter"])) {
    $selectedDraw = $_GET["draw-filter"];
    $drawInformation = getDrawInformation($selectedDraw);
    switch ($selectedDraw) {
        case "U15":
            $selectedDrawText = "Under 15 Mixed";
            break;
        case "U16":
            $selectedDrawText = "Under 16 Mixed";
            break;
        case "U17":
            $selectedDrawText = "Under 17 Mixed";
            break;
        case "Senior":
            $selectedDrawText = "Senior Mixed";
            break;
    }
} else {
    // show senior mixed by default
    $selectedDraw = "Senior";
    $selectedDrawText = "Senior Mixed";
    $drawInformation = getDrawInformation("Senior");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Team Draws - Dolphins Touch Football Club</title>
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
            <h1>Team Draws</h1>
        </section>
    </header>
    <div id='main'> 
        <form action="draw.php" method="GET">
            <label for="draw-filter">Select Team:</label>
            <select id="draw-filter" name="draw-filter" onchange="this.form.submit()">
                <option value="U15" <?php if ($selectedDraw == "U15") echo "selected"; ?>>Under 15 Mixed</option>
                <option value="U16" <?php if ($selectedDraw == "U16") echo "selected"; ?>>Under 16 Mixed</option>
                <option value="U17" <?php if ($selectedDraw == "U17") echo "selected"; ?>>Under 17 Mixed</option>
                <option value="Senior" <?php if ($selectedDraw == "Senior") echo "selected"; ?>>Senior Mixed</option>
            </select>
        </form>
        <section id="draw-list">
            <h2><?= $selectedDrawText ?> Draw</h2>
            <ul>
                <?php foreach ($drawInformation as $matchInfo) { ?>
                    <li>
                        <p>Round <?= $matchInfo["ROUND"] ?> - <?= $matchInfo["DATE"] ?></p>
                        <div class="draw-team-details">
                            <div class="draw-team-info">
                                <img class="draw-team-logo" src="./images/<?= $matchInfo["T1_LOGO"] ?>" alt="<?= $matchInfo["TEAM1"] ?> Logo" />
                                <p><?= $matchInfo["TEAM1"] ?></p>
                            </div>
                            <div class="draw-time-or-score">
                                <?php if ($matchInfo["SCORE_1"] != "") { ?>
                                    <span class="draw-score-1"><?= $matchInfo["SCORE_1"] ?></span>

                                    <span>MATCH DONE</span>
                                    <span class="draw-score-2"><?= $matchInfo["SCORE_2"] ?></span>
                                <?php } else { ?>
                                    <time class="draw-time"><?= $matchInfo["TIME"] ?></time>
                                <?php
                                } ?>
                            </div>
                            <div class="draw-team-info">
                                <img class="draw-team-logo" src="./images/<?= $matchInfo["T2_LOGO"] ?>" alt="<?= $matchInfo["TEAM2"] ?> Logo" />
                                <p><?= $matchInfo["TEAM2"] ?></p>
                            </div>
                        </div>
                        <p><?= $matchInfo["LOCATION"] ?></p>
                    </li>
                <?php } ?>
            </ul>
        </section>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>