<?php
    require_once("./db/queryDb.php");

    $standingsInformation = getStandingsInformation("Senior");
    
    // do this stuff when you have time otherwise it's too stupid to do honestly
    // require_once("./db/calculateDraw.php");
    // $drawInformation = getDrawInformation("Senior");
    // calculateDrawData($drawInformation);
    // echo "<pre>";
    // print_r($drawInformation);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Standings - Dolphins Touch Football Club</title>
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
            <h1>League Standings</h1>
        </section>
    </header>
    <div id='main'>
        <section id="standings-section">
            <h2>Senior Mixed Standings</h2>
            <div id="standings-table-section">
                <table id="standings-table">
                    <thead>
                        <tr class="standings-row">
                            <th class="standings-cell1">Pos</th>
                            <th class="standings-cell2">Team</th>
                            <th class="standings-generic-cell">Played</th>
                            <th class="standings-generic-cell">Points</th>
                            <th class="standings-generic-cell">Wins</th>
                            <th class="standings-generic-cell">Losses</th>
                            <th class="standings-generic-cell">Diff.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($standingsInformation as $standings) {
                        ?>
                        <tr class="standings-row">
                            <td class="standings-cell1"><?=$standings['POS']?></td>
                            <td class="standings-cell2">
                                <img class="standings-team-logo" src="images/<?=$standings['LOGO']?>" alt="<?=$standings['TEAM_NAME']?> Logo"/>
                                <p class="standings-team-text"><?=$standings['TEAM_NAME']?></p>
                            </td>
                            <td class="standings-generic-cell"><?=$standings['PLAYED']?></td>
                            <td class="standings-generic-cell"><?=$standings['POINTS']?></td>
                            <td class="standings-generic-cell"><?=$standings['WINS']?></td>
                            <td class="standings-generic-cell"><?=$standings['LOSSES']?></td>
                            <td class="standings-generic-cell"><?=$standings['DIFFERENTIAL']?></td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>