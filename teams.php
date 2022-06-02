<!DOCTYPE html>
<html>

<head>
    <title>Our Teams - Dolphins Touch Football Club</title>
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
            <h1>Our Teams</h1>
        </section>
    </header>
    <div id='main'>
        <section id="team-table-section">
            <h2>Teams Table</h2>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Team Name</th>
                        <th colspan="5">Team Information</th>
                    </tr>
                    <tr>
                        <th>Training Times</th>
                        <th>Coaching Information</th>
                        <th>Who Can Join</th>
                        <th>Joining Costs</th>
                        <th>Join Us</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Under 15 mixed</td>
                        <td>5pm Tuesdays</td>
                        <td>
                            Bradley Smith 
                            <p>0412 345 678</p>
                        </td>
                        <td>This team is open to players of all genders and all ages. Generally restricted to 14 years
                            or below.</td>
                        <td>Annual Joining Fee $50</td>
                        <td>If you're interested in joining, please fill out your information at our 
                            <a href="./join.php">Join page</a>.</td>
                    </tr>
                    <tr>
                        <td>Under 16 mixed</td>
                        <td>6pm Tuesdays</td>
                        <td>
                            Rory Hamilton 
                            <p>0498 765 432</p>
                        </td>
                        <td>This team is open to players of all genders and all ages. Generally restricted to 15 years
                            or below.</td>
                        <td>Annual Joining Fee $60</td>
                        <td>If you're interested in joining, please fill out your information at our 
                            <a href="./join.php">Join page</a>.</td>
                    </tr>
                    <tr>
                        <td>Under 17 mixed</td>
                        <td>6pm Thursdays</td>
                        <td>
                            Alisson Terry, Enrique Torres 
                            <p>0411 123 123</p>
                        </td>
                        <td>This team is open to players of all genders and all ages. Generally restricted to 16 years
                            or below.</td>
                        <td>Annual Joining Fee $80</td>
                        <td>If you're interested in joining, please fill out your information at our 
                            <a href="./join.php">Join page</a>.</td>
                    </tr>
                    <tr>
                        <td>Senior mixed</td>
                        <td>7pm Tuesdays</td>
                        <td>
                            Sandra Alder, Henry Bridge 
                            <p>0400 555 555</p>
                        </td>
                        <td>This team is open to players of all genders and all ages. Generally restricted to 17 years
                            old or above.</td>
                        <td>Annual Joining Fee $100</td>
                        <td>If you're interested in joining, please fill out your information at our 
                            <a href="./join.php">Join page</a>.</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>