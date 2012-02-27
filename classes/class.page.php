<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Brian
 */
class page {
    var $id;
    var $user;
    var $status;
    var $date_modified;
    var $title;
    var $body;
    var $sidebar;
    var $permission_level;
       
    function __construct($page_id) {
        
			
        $dbstuff = new databee();
        $res = $dbstuff->query("SELECT * FROM page WHERE id=".$page_id.";");
        if(mysql_num_rows($res) != 0){
                while($row = mysql_fetch_assoc($res)) {
                        $this->id = $row['id'];
                        $this->user = new user($row['user_id']);
                        $this->status = $row['status_id'];
                        $this->date_modified = $row['date_modified'];
                        $this->title = $row['title'];
                        $this->body = $row['body'];
                        $this->sidebar = $row['sidebar'];
                        $this->permission_level = $row['permission_level'];
                }
        }
    }
    
    function get_modified_date() {
        return date('M d y g:i a', strtotime(TIME_OFFSET, strtotime($this->date_modified)));
    }
}

?>
