<?php

/*
 *  STATUS.PHP
 *
 *  The page shows your status messages
 *  It grabs the status messages 
 *  and generating the sentiment for them using the API from http://help.sentiment140.com/api
 *                  Copyright (C) <2013>  <NeaIon>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

require_once 'fb/auth.php';

// If there is no logged in user, redirect to login.php
if(!$user)
  header("Location: login.php");

function compare_statuses($status1, $status2) {
  // Calculate scores based on 1.5 * comment + like
  $score1 = (1.5 * $status1["comment_count"]) + $status1["like_count"];
  $score2 = (1.5 * $status2["comment_count"]) + $status2["like_count"];

  // Compare the two scores
  return $score2 - $score1;
}

function get_response_count($status, $type) {
	global $facebook;
  $max_returned = 25; // The maximum number of likes fb returns by default

  $response_count = count($status[$type]["data"]);
  // If response count == $max_returned, most likely there are more. Fetch 100 of them
  // and display 100+ if we get 100.

  if($response_count == $max_returned) {
    $responses = $facebook->api("/".$status["id"]."/".$type, "GET", array("limit"=>"100"));
    $response_count = count($responses["data"]);
    if($response_count == 100) { $response_count = "100+"; }
  }
  return $response_count;
}
function array_sort($arr){
    if(empty($arr)) return $arr;
    foreach($arr as $k => $a){
        if(!is_array($a)){
            arsort($arr); // could be any kind of sort
            return $arr;
        }else{
            $arr[$k] = array_sort($a);
        }
    }
    return $arr;
}
function sentiment($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function polaritate($url) {
	$rezultate = (sentiment($url)); 
	    $obj = json_decode($rezultate, true);
		$foo = $obj[results];
	return $foo;
}
function mesajPostat($Stare){
	if ($Stare == 4) 
            {$StareDeFacto = print_r("<br/><h4>POZITIV!</h4><br/><a href='http://www.youtube.com/watch?v=d2oQ6VbVIco'>Vizionati ceva infricosator.</a><br/>");}

	if ($Stare == 0)  
	       {$StareDeFacto = print_r("<br/></h4>NEGATIV!</h4><br/><a href='http://www.youtube.com/user/funnymadshow?feature=chclk'>Vizionati ceva mai funny :)</a><br/>");}

	if ($Stare == 2) 
	        {$StareDeFacto = print_r("<br/></h4>NEUTRU!</h4><br/><a href='http://www.youtube.com/watch?v=at_f98qOGY0'>Vizionati ceva normal.</a><br/>");}

	return $StareDeFacto;
    }
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
  <title>O lista cu postarile tale:</title>
</head>
<body>
  <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>
        Toate postarile tale
        <small>dupa codul facut de Ionut CAPTARI</small>
      </h1>
    </div>
	
   <?php
    
    // Fetch the user's last 100 statuses
    $statuses = $facebook->api('/'.$user.'/statuses', "GET", array("limit"=>"100"));
    $statuses = $statuses["data"];

    // Sort the statuses using our custom ranking function
 //rsort($statuses, array_sort);

?>
	
<h3>Doar mesajele din postari:</h3>
<pre>

	<?php 

    $i = 0;	
    foreach($statuses as $status) 
	{   
		$pat = $status["message"];
		$urlul = strstr($pat, "http");
		$text = substr($pat, 0, strpos( $pat, 'http'));
		$i++;
	    
		echo "<div class='well'>";
		echo "<center><h4>Mesajul nr ". $i.":</h4></center><br/>";
			if ($text)
				{
				echo "<br/>Mesaj cu URL inclus !!!<br/>";
				echo $text;
				echo "<br/>Url:<br/>" ;
				echo "<a href='". $urlul. " '>" . $urlul . "</a><br/>";
				echo "<br/>-----------------------------------------------------------------------------------<br/>";
				echo "<br/>Sentimentul acestui post este:".$vari."<br/>";
				echo "<a href='http://www.sentiment140.com/api/classify?text=". urlencode($text). "'>http://www.sentiment140.com/api/classify?text=". urlencode($text). "'</a>";
				$polar = polaritate("http://www.sentiment140.com/api/classify?text=". urlencode($text). "");
				echo mesajPostat($polar);				
		        echo "<br/><h1>--------------------------------------------</h1><br/>";
				}
				
			if ($urlul === false)
			    {
				echo "<br/>Mesaj Simplu !!!<br/>";
				echo $pat;	
				echo "<br/>-----------------------------------------------------------------------------------<br/>";
				echo "<br/>Sentimentul acestui post este:".$vari."<br/>";
				echo "<a href='http://www.sentiment140.com/api/classify?text=". urlencode($pat). "'>http://www.sentiment140.com/api/classify?text=". urlencode($pat). "'</a>";				
				$polar = polaritate("http://www.sentiment140.com/api/classify?text=". urlencode($text). "");
				echo mesajPostat($polar);
				echo "<br/><h1>--------------------------------------------</h1><br/>";
				}
				
			if ($text === false && $urlul)
			    {
				echo "<br/>Mesaj Link !!!<br/>";
				echo "<br/>Url:<br/>" ;
				echo "<a href='". $text. " '>" . $pat . "</a><br/>";
				echo "<br/>-----------------------------------------------------------------------------------<br/>";
				echo "<br/>Mesaj fara a putea genera sentiment!<br/>";
				echo "<br/><h1>--------------------------------------------</h1><br/>";
				}
			if ($urlul === false && $text === false)
			    {	echo "<br/>Gooolll !!!<br/>";}
				
		if($status["like_count"]) { echo "<br/>".$status["like_count"]." au dat like<br/>";}
        if($status["comment_count"]){ echo $status["comment_count"]." au comentat<br/>";}
		echo "</div>";
		
    }  	
?>

</pre>
	
	
  </div>
  </body>
</html>
