<?PHP
require_once("./include/membersite_config.php");

if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("index.php");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Login</title>
      <link rel="STYLESHEET" type="text/css" href="stylesheets/login-box.css" />
      
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>

<div id="login-box">

<H2>Cupcake Bakery</H2>
Please Login for Them Cupcakes.
<br />
<br />
<form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<input type='hidden' name='submitted' id='submitted' value='1'/>    
    
<div id="login-box-name" style="margin-top:20px;">Username:</div><div id="login-box-field" style="margin-top:20px;"><input name="username" id="username" class="form-login" title="Username" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" id="password" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" /></div>
<br />
<!--<span class="login-box-options"><input type="checkbox" name="1" value="1"> Remember Me <a href="#" style="margin-left:30px;">Forgot password?</a></span>-->
<br />
<br />
<input type="image" name="Submit" src="images/login-btn.png" height="42" width="103" style="margin-left:90px;" alt="Submit Form"/>
</form>

</div>   


</body>
</html>