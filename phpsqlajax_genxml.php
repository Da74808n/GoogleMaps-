<?php

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$link=mysqli_connect ('localhost', $username, $password, $database);
if (!$link) {  die('Not connected : ' . mysql_error());}

// Select all the rows in the markers table

$query = "SELECT * FROM GoogleMaps";

header("Content-type: text/xml");

if($result = mysqli_query($link, $query)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $node = $dom->createElement("marker");
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute("name",$row['name']);
            $newnode->setAttribute("address", $row['address']);
            $newnode->setAttribute("lat", $row['lat']);
            $newnode->setAttribute("lng", $row['lng']);
            $newnode->setAttribute("type", $row['type']);
        }
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

echo $dom->saveXML();

?>