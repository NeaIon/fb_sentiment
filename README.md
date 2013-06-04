NeaIon: FB Sentiment
=========================

Code for Infoiasi 2013 with the help of the FB API 
Uses the php sdk to pull and manipulate various sets of data from Facebook 

Status.php
----------
Does a basic open graph query to pulls your last 20 statuses also generating a sentiment
with http://help.sentiment140.com/api

Event.php
---------
Uses FQL multiquery to first grab all of your friends, then all the ids of events they are attending and finally information about those events (name and picture)
Displays the 10 events that have the most number of friends who have responded attending.

Note:
-----
You need to enter your own app id and secret in /fb/config.php in order to make it work for you
