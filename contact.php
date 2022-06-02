<?php
    if(isset($_POST["enquiry-name"])) {
        $message = "Enquiry submitted successfully. The Club will contact you at our earliest convenience.";
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Contact Us - Dolphins Touch Football Club</title>
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
            <h1>Contact Us</h1>
        </section>
    </header>
    <div id='main'>
        <section id="contact-details">
            <?php 
                if(isset($message)) {?>
            <p id="enquiry-success-message"><?=$message?></p>
            <?php 
                } ?>
            <h2>Dolphin's Touch Football Limited</h2>
            <ul itemscope itemtype="https://schema.org/Organization">
                <li itemprop="address" itemscope itemtype="http://schema.org/Text">
                    <span itemprop="streetAddress">Calamvale District Park, 31 Formby Street</span>,
                    <span itemprop="addressLocality">Calamvale</span>,
                    <span itemprop="addressRegion"></span>Queensland</span>,
                    <span itemprop="postalCode">4116</span>
                </li>
                <li>Tel: 1300 GO DTFC (<span itemprop="telephone">1300 463 832</span>)</li>
                <li>Fax: <span itemprop="faxNumber">07 3897 1234</span></li>
                <li itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">Postal:
                    <span itemprop="streetAddress">PO Box 1234</span>,
                    <span itemprop="addressLocality">Calamvale</span>,
                    <span itemprop="addressRegion">Qld</span>,
                    <span itemprop="postalCode">4116</span>
                </li>
                <li>Web: <a href="https://s5251427.elf.ict.griffith.edu.au/assignment/" target="_blank">dtfc.com.au</a>
                </li>
                <li>Facebook: <a href="https://facebook.com/dtfootballclub/" target="_blank">facebook.com/dtfc</a></li>
                <li>Twitter: <a href="https://twitter.com/dtfootballclub/" target="_blank">@dtfcfootball</a></li>
                <li>Instagram: <a href="https://www.instagram.com/dtfootballclub/" target="_blank">@dtfcfootball</a>
                </li>
            </ul>
            <div id="map-image-container">
                <a href="https://www.google.com/maps/place/Calamvale+District+Park/@-27.6219552,153.0357295,17z/data=!3m1!4b1!4m5!3m4!1s0x6b9145ebb4db8455:0xf02a35bd72270d0!8m2!3d-27.62196!4d153.0379182"
                    target="_blank">
                    <img src="images/dtfc_location_map_resized.png" alt="Calamvale District Park" />
                </a>
            </div>
        </section>
        <section>
            <h2>Enquiry Form</h2>
            <form action="contact.php" method="POST">
                <label for="enquiry-name">Your Name</label>
                <input type="text" id="enquiry-name" name="enquiry-name" required/>
                <label for="enquiry-email">Your Email</label>
                <input type="text" id="enquiry-email" name="enquiry-email" required/>
                <label for="enquiry-phone">Your Phone</label>
                <input type="text" id="enquiry-phone" name="enquiry-phone" required/>
                <label for="enquiry-query">Your Query</label>
                <textarea id="enquiry-query" name="enquiry-query" maxlength="500" required></textarea>
                <input type="submit" id="submit" value="Submit Enquiry" />
            </form>
        </section>
        <section>
            <h2>Executives</h2>
            <dl>
                <span itemscope itemtype="https://schema.org/Person">
                    <dt itemprop="jobTitle">President</dt>
                    <dd itemprop="name">Mrs Touch Football Master</dd>
                </span>
                <span itemscope itemtype="https://schema.org/Person">
                    <dt itemprop="jobTitle">Vice-President</dt>
                    <dd itemprop="name">Mr Todd Smith</dd>
                </span>
                <span itemscope itemtype="https://schema.org/Person">
                    <dt itemprop="jobTitle">Secretary</dt>
                    <dd itemprop="name">Mr Billy Brown</dd>
                </span>
                <span itemscope itemtype="https://schema.org/Person">
                    <dt itemprop="jobTitle">Head Coach</dt>
                    <dd itemprop="name">Ms Can-Kick A-Ball</dd>
                </span>
            </dl>
        </section>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>