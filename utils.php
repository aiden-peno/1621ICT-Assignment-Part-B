<?php

// Utility function
function getTable($table) {
    $db = new MyDB();
    if(!$db){
       echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
    } else {
       //echo "Opened database successfully\n";
    }

    $sql ='SELECT * from ' . $table;
    $ret = $db->query($sql);
    $array = [];
    if(!$ret){
      echo $db->lastErrorMsg();
      return [];
    } else {
       while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
          $array[] = $row;
       }
       $db->close();
       return $array;
    }
 }

// Utility function
function clearTable($table, $id) {
    $db = new MyDB();
    if(!$db){
        echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
    } else {
        //echo "Opened database successfully\n";
    }
    
    $sql ='DELETE FROM ' . $table .' WHERE "ID" > '.$id.';';
    $ret = $db->query($sql);
}

function clearCommunityData($table) {
$db = new MyDB();
if(!$db){
    echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
} else {
    //echo "Opened database successfully\n";
}

$sql ='DELETE from ' . $table .' WHERE ID > 10;';
$ret = $db->query($sql);
}

function create_guid() { // Create GUID (Globally Unique Identifier)
    $guid = '';
    $namespace = rand(11111, 99999);
    $uid = uniqid('', true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash, 0, 8) . '-' .
        substr($hash, 8, 4) . '-' .
        substr($hash, 12, 4) . '-' .
        substr($hash, 16, 4) . '-' .
        substr($hash, 20, 12);
    return $guid;
}
