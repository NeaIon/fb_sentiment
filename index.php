<?php

/*
 *  INDEX.PHP
 *  
 *  Landing page of the site. Provides links to go to each feature built
 *
 */

require_once 'fb/auth.php';

// If there is no logged in user, redirect to login.php
if(!$user) 
  header("Location: login.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <meta name="description" lang="ro" xml:lang="ro"
               content="Proiect la disciplina Tehnologii Web"/>
            <meta name="keywords" lang="ro" xml:lang="ro"
               content="Web, WWW, technologie, informatica, facultate, universitate, proiect, programare, software, infoiasi, tw2013"/>
            <meta name="author" content="Ionut Captari - http://www.neaion.ro"/> 
</head>
<body>
  <div class="container" style="margin-top: 20px">
    <div class='page-header'>
      <h1>
        Your sentiments generated from your latest statuses - Proiect Infoiasi 2013<br/><br/>
        <small>Proiect no.22 : MoSoR (Mood Social Recommender)</small><br/><br/>
		<small>ROU:  Se doreste implementarea unei aplicatii Web care sa analizeze mesajele emise pe Twitter si Facebook pentru a pune la dispozitie recomandari de resurse in functie de starea de spirit a utilizatorului --aceasta poate fi stabilita dinamic de catre utilizator sau (bonus) va putea fi detectata automat.</small><br/><br/>
		<small>EN:  We need to implement a web app which will analyze posts on Twitter and on Facebook and suggest recommendations according to users sentiments --  this can be dynamically set by the user or (bonus) will be automatically detected.</small><br/>
      <small><br/>Resources: <a href="http://help.sentiment140.com/api"> http://help.sentiment140.com/api</a></small><br/>
	  </h1>
    </div>
    <div class="btn-group">
      <a class='btn' href='status.php'>Status sentiment (Open graph)</a>
      <a class='btn' href='event.php'>Friends events (FQL Multiquery)</a>
    </div>
  </div>
</body>
</html>
