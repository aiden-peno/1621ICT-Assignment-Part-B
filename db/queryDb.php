<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
            $this->open('./db/DTFC.db');
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

   function validateUser($username, $password) {
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }
      $sql ='SELECT EMAIL FROM USERS WHERE EMAIL LIKE "'.$username.'" AND PASSWORD LIKE "'.$password.'";';
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

   function getUser($email) {
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }
      
      $sql ='SELECT * FROM USERS WHERE EMAIL LIKE "'.$email.'";';
      
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

   function getDrawInformation($drawCode) {
      $db = new MyDB();
      if(!$db){
      echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
      //echo "Opened database successfully\n";
      }
      $sql ='SELECT "GAME_ID", "LEAGUE", "ROUND", "TEAM1", "TEAM2", "DATE", "TIME", "LOCATION", "SCORE_1", "SCORE_2", T1."LOGO" AS "T1_LOGO", T2."LOGO" AS "T2_LOGO" FROM DRAW INNER JOIN TEAMS AS "T1" ON TEAM1 = T1.NAME INNER JOIN TEAMS AS "T2" ON TEAM2 = T2.NAME WHERE LEAGUE LIKE "'.$drawCode.'" ORDER BY "ROUND" ASC;';
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
   
   function getStandingsInformation($drawCode) {
      $db = new MyDB();
      if(!$db){
      echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
      //echo "Opened database successfully\n";
      }
      $sql ='SELECT * FROM STANDINGS INNER JOIN TEAMS ON TEAM_NAME = NAME WHERE LEAGUE LIKE "'.$drawCode.'" ORDER BY "POS" ASC;';
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

   function getCommunityPosts($searchTerm = null, $searchDate = null) {
      $db = new MyDB();
      if(!$db){
      echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
      //echo "Opened database successfully\n";
      }
      if ($searchTerm && $searchDate) {
         $sql ='SELECT * FROM COMMUNITY WHERE (TITLE LIKE "%'.$searchTerm.'%" OR DESCRIPTION LIKE "%'.$searchTerm.'%") AND DATE > "'.$searchDate.'" ORDER BY "DATE" DESC;';
      } elseif ($searchTerm) {
         $sql ='SELECT * FROM COMMUNITY WHERE TITLE LIKE "%'.$searchTerm.'%" OR DESCRIPTION LIKE "%'.$searchTerm.'%" ORDER BY "DATE" DESC;';
      } elseif ($searchDate) {
         $sql ='SELECT * FROM COMMUNITY WHERE DATE > "'.$searchDate.'" ORDER BY "DATE" DESC;';
      } else {
         $sql ='SELECT * FROM COMMUNITY ORDER BY "DATE" DESC;';
      }
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

   function addCommunityPost($title, $description, $imageLocation) {
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO COMMUNITY (TITLE, DESCRIPTION, IMAGE_LOCATION, DATE) VALUES ("'.$title.'", "'.$description.'", "'.$imageLocation.'", date());';
      $ret = $db->query($sql);
      return $ret;
   }

   function getUsers($searchTerm = null) {
      
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }
      if(!$searchTerm) {
         $sql ='SELECT * from USERS;';
      } else {
         $sql ='SELECT * FROM USERS WHERE FIRSTNAME LIKE "'.$searchTerm.'" OR LASTNAME LIKE "'.$searchTerm.'" OR ADDRESS LIKE "'.$searchTerm.'" OR PHONE  LIKE "'.$searchTerm.'"';
      }
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
   
   function addUser($fname, $lname, $gender, $dob, $team, $phone, $email, $address_street, $address_suburb, $address_postcode, $address_state, $cob, $nationality, $disability, $cultural_origin, $eng_first, $lote, $emergency_name, $emergency_phone, $emergency_email, $password) {
      $array = [];
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO USERS (FIRST_NAME, LAST_NAME, GENDER, DOB, TEAM, PHONE, EMAIL, ADDRESS_STREET, ADDRESS_SUBURB, ADDRESS_POSTCODE, ADDRESS_STATE, BIRTH_COUNTRY, NATIONALITY, DISABILITY, CULTURAL_ORIGIN, ENGLISH_PRIMARY, LOTE, EMERGENCY_NAME, EMERGENCY_PHONE, EMERGENCY_EMAIL, PASSWORD) VALUES ("'.$fname.'", "'.$lname.'", "'.$gender.'", "'.$dob.'", "'.$team.'", "'.$phone.'", "'.$email.'", "'.$address_street.'", "'.$address_suburb.'", "'.$address_postcode.'", "'.$address_state.'", "'.$cob.'", "'.$nationality.'", "'.$disability.'", "'.$cultural_origin.'", "'.$eng_first.'", "'.$lote.'", "'.$emergency_name.'", "'.$emergency_phone.'", "'.$emergency_email.'", "'.$password.'");';
      $ret = $db->query($sql);
      return $ret;
   }
   
   function addCustomer($fname, $lname, $address, $phone) {
      
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO CUSTOMERS (FIRSTNAME, LASTNAME, ADDRESS, PHONE) VALUES ("'.$fname.'", "'.$lname.'", "'.$address.'", "'.$phone.'");';
      $db->query($sql);
   }
   
   
   function addProduct($pname, $man, $desc, $price) {
      
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO PRODUCTS (PRODUCTNAME, MANUFACTURER, DESCRIPTION, PRICE) VALUES ("'.$pname.'", "'.$man.'", "'.$desc.'", "'.$price.'");';
      $db->query($sql);
   }
   
   
   function addEvent($ename, $loc, $desc, $date) {
      
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='INSERT INTO EVENTS (EVENTNAME, LOCATION, DESCRIPTION, DATE) VALUES ("'.$ename.'", "'.$loc.'", "'.$desc.'", "'.$date.'");';
      $db->query($sql);
   }
   
      
?>