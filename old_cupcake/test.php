<?php

echo "//-//-//user testing///<br />";
$user = new user(1);
echo "Display Name: ".$user->displayname."<br />";
echo "Username: ".$user->username."<br />";
echo "Email: ".$user->email."<br />";
echo "Votes: ".$user->votes_up."/".$user->votes_down."<br />";
echo "Title: ".$user->title."<br />";
echo "Join//Last: ".$user->joinDate."//".$user->lastDate."<br />";
echo "Active: ".$user->active."<br />";

echo "<br /><br />";
echo "//-//-//cupcake//////<br />";
$cupcake = new cupcake();
$cupcake->fill_values(1);
echo "Title: ".$cupcake->title."<br />";
echo "Date: ".$cupcake->publicationDate."<br />";
echo "Author: ".$cupcake->user->displayname."<br />";
echo "Votes: ".$user->votes_up."/".$user->votes_down."<br />";
echo "Summary: ".$cupcake->summary."<br />";
echo "Content: ".$cupcake->content."<br />";
echo "<br /><br />";
echo "//-//-//episode//////<br />";
$episode = new episode();
$episode->fill_values(1);
echo "Link: <a href=\"player.php?id=".$episode->id."\">Play Episode</a>";
echo "Show: ".$episode->show->name."<br />";
echo "Season: ".$episode->season->number."<br />";
echo "User: ".$episode->user->displayname."<br />";
echo "Name: ".$episode->number." - ".$episode->name."<br />";
echo "Description: ".$episode->description."<br />";
echo "Active: ".$episode->active."<br />";
echo "Hits: ".$episode->hits."<br />";
echo "Date_added: ".$episode->date_added."<br />";
echo "Votes: ".$episode->votes_up."/".$episode->votes_down."<br />";

echo "<br /><br />";
echo "//-//-//shows//////<br />";
$show = new show(4);
$show->getAll();

?>

