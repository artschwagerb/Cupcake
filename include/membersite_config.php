<?PHP
require_once("./include/fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('Cupcake');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('artschwagerb@my.uwstout.edu');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, users in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'localhost',
                      /*username*/'cup',
                      /*password*/'HBnzUemAHSqtCprW',
                      /*database name*/'cupcake',
                      /*table name*/'u_user');
					  
//$fgmembersite->InitDB(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_DATABASE,'users');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('qSRcVS6DrTzrPvr');

?>