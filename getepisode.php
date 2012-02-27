<?php
ini_set("memory_limit","16M");
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
include "config.php";
/*
if(empty($_GET["id"])){
echo "episode id not provided.";
}else{
    if($_GET["token"] == "brianrocks123"){
        
        $episode = new episode($_GET["id"]);
        //Log a view----------
        $episode->log_View();
*/

        // Hard-Coded for the test
        $file = "/media/sdk1/home/cupcake/www/cupcakesfor.me/videos/tngfevaseth_qt.mp4";
        //$file = $episode->filename;
        echo $file;
        /*
        if (file_exists($file))
            {
                header('Last-Modified:	Thu, 23 Sep 2010 02:00:02 GMT');
                header('ETag:	"c0101-309f8-490e39ebcec80"');
                header('Accept-Ranges:	bytes');
                header('Content-Length:	' . filesize($file));
                header('Connection:	open');
                header('Content-Type:	video/mp4');
                header('X-Pad:	avoid browser bug');
                ob_clean();
                flush();
                readfile($file);
                exit;
            }
           */ 
        header("Content-Type: $mediatype");

        if ( empty($_SERVER['HTTP_RANGE']) )
        {
            header("Content-Length: $filesize");

            $fh = fopen($file, "rb") or die("Could not open file: " .$file);

            # output file
            while(!feof($fh))
            {
                # output file without bandwidth limiting
                echo fread($fh, $filesize);
            }
            fclose($fh);
        }
        else //violes rfc2616, which requires ignoring  the header if it's invalid
        {   
            rangeDownload($file);
        }    
            /*
    }else{
        echo "nope";
    }
}
             */
             
?>
