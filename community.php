<?php
    require_once("./db/queryDb.php");
    require_once("utils.php");

    // check user is logged in - show post form if they are
    $userLoggedin = isset($_COOKIE["user"]);

    // only show message text if post submission was attempted
    $messageSectionClass = "display-none";

    if (isset($_POST["community-form-title"])) {
        // if image was submitted
        if($_FILES["community-form-image"]["name"] !== "") {
            // generate a GUID for the filename so there's no issues with same name files
            $uniqueFileName = create_guid();
            // get file extension
            $imageFileType = strtolower(pathinfo($_FILES["community-form-image"]["name"], PATHINFO_EXTENSION));
            // set target file details
            $targetDir = "./images/community/";
            $targetFile = $targetDir . ($uniqueFileName). "." . $imageFileType;

            // array to hold any error messages that occur
            $errorArray = Array();
            // error message string
            $errorMessage = "";
            // error with file checking flag - set to 0 if error occurs
            $uploadOk = 1;
            
            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["community-form-image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($errorArray, "File is not an image.");
                $uploadOk = 0;
            }

            //check file size
            $fileSizeAllowanceBytes = 1000000;
            $fileSizeAllowanceKiloBytes = 1000;
            if ($_FILES["community-form-image"]["size"] > $fileSizeAllowanceBytes) {
                // get size in kilobytes
                $size = round($_FILES["community-form-image"]["size"] / 1000);
                // calculate size over allowance
                $sizeOver = $size - $fileSizeAllowanceKiloBytes;
                array_push($errorArray, "Your file is too large (".$size."kB - ".$sizeOver."kB over limit).");
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errorMessage = "Sorry, your post was not submitted.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["community-form-image"]["tmp_name"], $targetFile)) {
                    // if file successfully stored to server, add the community post to the DB, saving only the image location to DB instead of whole image
                    addCommunityPost($_POST["community-form-title"], $_POST["community-form-description"], $targetFile);
                    $successMessage = "Your post is being uploaded, we will refresh the page when complete!";
                } else {
                    $errorMessage = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            // add community post to DB without image
            addCommunityPost($_POST["community-form-title"], $_POST["community-form-description"], "./images/dolphins_logo.svg");
        }
        // display appropriate messages by setting classes to message element
        if (isset($errorMessage) && $errorMessage != "") { 
            $messageSectionClass = "community-post-error-messages"; 
        } elseif (isset($successMessage) && $successMessage != "") { 
            $messageSectionClass = "community-post-success-messages"; 
        } else {
            $messageSectionClass = "display-none";
        }
    }

    // as they're optional, need to initialise the values to search
    $searchTerm = "";
    $searchDate = "";
    if (isset($_GET["community-search-term"])) {
        $searchTerm = $_GET["community-search-term"];
    } 
    if (isset($_GET["community-search-start-date"])) {
        $searchDate = $_GET["community-search-start-date"];
    }
    // get community posts from DB with appropriate parameters depending on which fields were populated by user
    if ($searchTerm != "" && $searchDate != ""){
        $communityPosts = getCommunityPosts($searchTerm, $searchDate);
    } elseif($searchDate != "") {
        $communityPosts = getCommunityPosts(null, $searchDate);
    } elseif($searchTerm != "") {
        $communityPosts = getCommunityPosts($searchTerm);
    } else {
        $communityPosts = getCommunityPosts();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Community Posts - Dolphins Touch Football Club</title>
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
        <!-- <nav id="nav-links">
            <ul>
                <li><a href='./teams.php'>Teams</a></li>
                <li><a href='./join.php'>Join</a></li>
                <li><a href='./draw.php'>Draw</a></li>
                <li><a href='./standings.php'>Standings</a></li>
                <li><a href='./community.php'>Community</a></li>
                <li><a href='./contact.php'>Contact</a></li>
                <li><a href='./account.php'>Account</a></li>
            </ul>
        </nav> -->
        <section id="page-title">
            <h1>Our Community</h1>
        </section>
    </header>
    <div id='main'>
        <?php if ($userLoggedin) { ?>
        <section class=<?=$messageSectionClass?>>
            <?php 
                if(isset($errorMessage) && $errorMessage != "") {
                    echo "<p>".$errorMessage."</p>";

                    foreach ($errorArray as $error) {
                        echo "<p>".$error."</p>";
                    }
                } elseif (isset($successMessage) && $successMessage != "") {
                    echo "<p>".$successMessage."</p>";
            ?>
                <script>
                    setTimeout(function () {
                        window.location.replace("./community.php");
                    }, 5000);
                </script>
            <?php
                }
            ?>
        </section>
        <section>
            <a href='javascript:void(0);' onclick='collapseCommunityPostForm()'>
                <div id="community-post-form-title">
                    <i id="community-post-form-toggle-button" class="fa-solid fa-chevron-right"></i>
                    <h2>Submit New Post</h2>
                </div>
            </a>
            <form id="community-post-form" action="community.php" method="POST" enctype="multipart/form-data" class="display-none">
                <label for="community-form-image">Select Image to Share (maximum size 1000 kB)</label>
                <input type="file" id="community-form-image" name="community-form-image" accept=".jpg, .JPG, .png, .PNG, .gif, .GIF"/>
                <label for="community-form-title">Enter Title for Post</label>
                <input type="text" id="community-form-title" name="community-form-title" maxlength="50" required/>
                <label for="community-form-description">Enter Description for Post</label>
                <textarea id="community-form-description" name="community-form-description" maxlength="250" required></textarea>
                <input type="submit" value="Submit" />
            </form>
        </section>
        <?php }?>
        <section>
            <a href='javascript:void(0);' onclick='collapseCommunitySearchForm()'>
                <div id="community-search-form-title">
                    <i id="community-search-form-toggle-button" class="fa-solid fa-chevron-right"></i>
                    <h2>Search Posts</h2>
                </div>
            </a>
            <form id="community-search-form" action="community.php" method="GET" <?php if (count($communityPosts) == 0) { echo "class='display-block'"; } else { echo "class='display-none'"; } ?>>
                <label for="community-search-term">Search Text</label>
                <input type="text" id="community-search-term" name="community-search-term" <?php if (isset($_GET["community-search-term"])) echo "value=\"".$_GET['community-search-term']."\""; ?> />
                <label for="community-search-start-date">Limit Results From</label>
                <input type="date" id="community-search-start-date" name="community-search-start-date" <?php if (isset($_GET["community-search-start-date"])) echo "value=\"".$_GET['community-search-start-date']."\""; ?> />
                <input type="submit" value="Submit" />
                <input type="reset" value="Reset Search" onClick="clearUrl('./community.php')" />
            </form>
        </section>
        <section id="community-posts">
            <h2>Posts From the Community (<?=count($communityPosts)?>)</h2>
            <!-- All default images sourced from commons.wikimedia.org -->
            <section id="community-post-list">
                <?php 
                    if (count($communityPosts) == 0) {
                        echo "<p>No posts match your search query. Please try again.</p>";
                    } else {
                        foreach ($communityPosts as $post) {
                ?>
                <a class="community-post-link" href="<?=$post["IMAGE_LOCATION"]?>" target="_blank">
                    <section class="community-post">
                        <img class="community-post-image" src="<?=$post["IMAGE_LOCATION"]?>" alt="<?=$post["TITLE"]?>" />
                        <div class="community-post-text">
                            <h3 class="community-post-title"><?=$post["TITLE"]?></h3>
                            <p class="community-post-description"><?=$post["DESCRIPTION"]?></p>
                        </div>
                    </section>
                </a>
                <?php 
                        }
                    }
                ?>
            </section>
        </section>
    </div>
    <footer id="footer">
        <small><a href="./sitemap.xml">Sitemap</a></small>
        <small id="copy-text">&copy; 2022 - Aiden Peno</small>
    </footer>
</body>

</html>