<?php

class admin {
	
    function addUser(){
        //if($_SESSION['status_of_user'] == 9){
            $dbstuff = new databee();
            $dbstuff->execute("INSERT INTO u_user (name, email, username, password, confirmcode, displayname, status_id, last_ip, premium_ex_date) VALUES ('".addSlashes($_POST['user-name'])."', '".addSlashes($_POST['user-email'])."', '".addSlashes($_POST['user-username'])."', MD5('".addSlashes($_POST['user-password'])."'), 'y', '".addSlashes($_POST['user-displayname'])."', '".addSlashes($_POST['user-status_id'])."', 'never logged in', '".addSlashes(date($_POST['user-premium_ex_date']))."')");
            
            //$res = $dbstuff->query("SELECT id from u_user WHERE username='".addSlashes($_POST['user-username'])."';");
            //if(mysql_num_rows($res) != 0){
		//while($row = mysql_fetch_assoc($res)) {
                    return mysql_insert_id();
                    
                //}
                //return 0;
            //}
        //}
        
    }
	

}