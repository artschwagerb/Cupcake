<!DOCTYPE html>
<?php
require_once("./include/membersite_config.php");

if (!$fgmembersite->CheckLogin()) {
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
include "config.php";
include TEMPLATE_PATH . "/header.php";

$page = new page(2);
?>
<script type="text/javascript">
    $(document).ready(function() {
     $('.edit').editable('http://10.0.50.26/page.php', { 
     });
 });
</script>
<div class="row">
    <div class="eight columns">
        <div class="edit" id="div_1"><?php echo nl2br($page->body); ?></div>
<div class="edit_area" id="div_2"><?php echo nl2br($page->body); ?></div>
        
    </div>

    <div class="four columns">			
        <?php echo nl2br($page->sidebar); ?>
    </div>
</div>

<?php
include TEMPLATE_PATH . "/footer.php";
?>