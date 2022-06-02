<?php
    // This page is called by checkEmailExists() from base.js to see if the entered email already exists. 
    // Page is returned as a JSON object to the calling function, set content-type
    header('Content-Type: application/json');

    class MyDB extends SQLite3
    {
        function __construct()
        {
            $this->open('./DTFC.db');
        }
    }

    function checkUserExists($email) {
        $db = new MyDB();
        if(!$db){
        echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
        } else {
        //echo "Opened database successfully\n";
        }
        $sql ='SELECT EMAIL FROM USERS WHERE EMAIL LIKE "'.$email.'";';
        $ret = $db->query($sql);
        $array = [];
        if(!$ret){
        //   echo $db->lastErrorMsg();
        //   return [];
            return $ret;
        } else {
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
            $array[] = $row;
        }
        $db->close();
        if (count($array) > 0) {
            return $array[0]["EMAIL"];
        } else {
            return false;
        }
        }
    }

    // only argument is the email entered
    $aResult = array();
    $aResult['result'] = checkUserExists($_POST['arguments'][0]);

    echo json_encode($aResult);
?>