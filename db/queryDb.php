<?php
   class MyDB extends SQLite3
   {
      function __construct()
      {
            $this->open('./db/DTFC.db');
      }
   }

   // Checks if the passed in email exists in the User table
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

   // basic authentication - ensure the passed in username and password exist in the User table
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

   // gets user details from the passed in email
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

   // gets draw information filtered by the passed in drawCode
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
   
   // gets standings information filtered by the passed in drawCode
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

   // gets community posts according to passed in params. If no params, returns all community posts
   function getCommunityPosts($searchTerm = null, $searchDate = null) {
      $db = new MyDB();
      if(!$db){
      echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
      //echo "Opened database successfully\n";
      }
      // can have no search terms, or just date, or just text, or both date and text. Order by date and post ID as no timestamp
      if ($searchTerm && $searchDate) {
         $sql ='SELECT * FROM COMMUNITY WHERE (TITLE LIKE "%'.$searchTerm.'%" OR DESCRIPTION LIKE "%'.$searchTerm.'%") AND DATE >= "'.$searchDate.'" ORDER BY "DATE" DESC, "ID" DESC;';
      } elseif ($searchTerm) {
         $sql ='SELECT * FROM COMMUNITY WHERE TITLE LIKE "%'.$searchTerm.'%" OR DESCRIPTION LIKE "%'.$searchTerm.'%" ORDER BY "DATE" DESC, "ID" DESC;';
      } elseif ($searchDate) {
         $sql ='SELECT * FROM COMMUNITY WHERE DATE >= "'.$searchDate.'" ORDER BY "DATE" DESC, "ID" DESC;';
      } else {
         $sql ='SELECT * FROM COMMUNITY ORDER BY "DATE" DESC, "ID" DESC;';
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

   // adds community post to Community table
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

   // gets list of users in User table - used for utility purposes only
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
   
   // adds a user to User table with all of the passed in param values
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

   // updates basic user details with passed in param values
   function updateUser($fname, $lname, $phone, $email) {
      $array = [];
      $db = new MyDB();
      if(!$db){
         echo '<script type="text/javascript">alert("'.$db->lastErrorMsg().'");</script>';
      } else {
         //echo "Opened database successfully\n";
      }

      $sql ='UPDATE USERS SET FIRST_NAME = "'.$fname.'", LAST_NAME = "'.$lname.'", PHONE = "'.$phone.'" WHERE "EMAIL" = "'.$email.'";';
      $ret = $db->query($sql);
      return $ret;
   }
?>