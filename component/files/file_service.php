<?php

require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
$q = $_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q) > 0) {
    $hint = "";

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $query = "SELECT * FROM resource where id like '%$q%' ORDER BY title ASC";

    $data = mysqli_query($dbc, $query);



    while ($row = mysqli_fetch_array($data)) {

        echo $row['id'];
        $paper = '[' . $row['id'] . ']' . $row['authors'] . '.' . $row['title'] . $row['journal'] . $row['year'] . ',' . $row['pages'] . ',' . $row['publisher'];

        if ($hint == "") {
            /*
              $hint = "<a href='" .
              $z->item(0)->childNodes->item(0)->nodeValue .
              "' target='_blank'>" .
              $y->item(0)->childNodes->item(0)->nodeValue . "</a>"; */

            $hint = '<input type="button" value="' . $paper . '" style="width:200; height:20;" onClick="javascript:clk(\'' . $row['id'] . '\');" />';
        } else {
            /* $hint = $hint . "<br /><a href='" .
              $z->item(0)->childNodes->item(0)->nodeValue .
              "' target='_blank'>" .
              $y->item(0)->childNodes->item(0)->nodeValue . "</a>"; */
            $hint = $hint . '<br /><input type="button" value="' . $paper . '" style="width:200; height:20;" onClick="javascript:clk(\'' . $row['id'] . '\');" />';
        }
    }
}




// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint == "") {
    $response = "no suggestion";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>
