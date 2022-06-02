<?php
    require_once('./db/queryDb.php');    
    require_once('utils.php');    
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <form action="maintenance.php" method="GET">
        <input type="radio" name="table-action" value="read" required /> Read
        <input type="radio" name="table-action" value="delete" /> Reset
        <br/>
        <input type="radio" name="table-name" value="USERS" required /> USERS
        <input type="radio" name="table-name" value="TEAMS" required /> TEAMS
        <input type="radio" name="table-name" value="DRAW" required /> DRAW
        <input type="radio" name="table-name" value="COMMUNITY" required /> COMMUNITY
        <input type="radio" name="table-name" value="STANDINGS" required /> STANDINGS
        <br />
        <input type="submit" value="submit" />
    </form>
    <form action="maintenance.php" method="GET">
        <input type="radio" name="cookie-action" value="read" required /> Read
        <input type="radio" name="cookie-action" value="delete" required /> Delete
        <br/>
        <input type="radio" name="cookie-name" value="user" required /> user
        <input type="radio" name="cookie-name" value="All" /> All
        <br/>
        <input type="submit" value="submit" />
    </form>
<?php
if (isset($_GET["table-name"])) {
    $table = $_GET["table-name"];
    switch ($_GET["table-action"]) {
        case "read":
            echo "<pre>";
            echo "<h1>".$table."</h1>";
            print_r(getTable($table));
            echo "</pre>";
            break;
        case "delete":
            switch($table) {
                case "USERS":
                    clearTable($table, 5);
                    break;
                case "TEAMS":
                    clearTable($table, 20);
                    break;
                case "DRAW":
                    clearTable($table, 76);
                    break;
                case "COMMUNITY":
                    clearTable($table, 10);
                    break;
            }
            echo "<pre>";
            echo "<h1>Successfully Reset " . $table . "</h1>";
            print_r(getTable($table));
            echo "</pre>";
            break;
    }
}
if (isset($_GET["cookie-action"])) {
    $cookie = $_GET["cookie-name"];
    switch ($_GET["cookie-action"]) {
        case "delete":
            if ($cookie == "All") {
                unset($_COOKIE["user"]); 
                setcookie("user");
            } else {
                unset($_COOKIE[$cookie]);
                setcookie($cookie);
            }
            break;
    }
}

if (isset($_COOKIE["user"])) {
    echo "<h1>Mine</h1>";
    echo "user: " . $_COOKIE["user"];
    echo "<br/>";
}
echo "<h1>All</h1>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
// clearTable();
?>
</body>
</html>