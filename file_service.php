<?php

require_once('appvars.php');
require_once('connectvars.php');
//get the q parameter from URL
$q = $_GET["q"];

function listArticles($dbc, $q) {
    if (!strncmp($q, BIBLIO, strlen(BIBLIO))) {
        $q = substr($q, strlen(BIBLIO));
    }

    $query = "SELECT * FROM resource where id like '%$q%' ORDER BY title ASC";

    $data = mysqli_query($dbc, $query);

    $hint = "";

    while ($row = mysqli_fetch_array($data)) {

        //echo $row['id'];
        $paper = '[' . $row['id'] . ']' . $row['authors'] . '.' . $row['title'] . '.' . $row['journal'] . ',' . $row['year'] . ',' . $row['pages'] . ',' . $row['publisher'] . '.';
        $text = '<label onClick="javascript:fileSelected(\'' . BIBLIO . $row ['id'] . '\');">' . $paper . '</label>';
        if ($hint == "") {
            /*
              $hint = "<a href='" . type="button"
              $z->item(0)->childNodes->item(0)->nodeValue .
              "' target='_blank'>" . style="width:200; height:20;"
              $y->item(0)->childNodes->item(0)->nodeValue . "</a>"; */

//$hint = '<input  class="btn btn-link" type="button" value="' . $paper . '"  onClick="javascript:fileSelected(\'' . $row['id'] . '\');" />';
//$hint = '<label onClick="javascript:fileSelected(\'' . $row['id'] . '\');">'. $paper .'</label>';
            $hint = $text;
        } else {
            /* $hint = $hint . "<br /><a href='" .
              $z->item(0)->childNodes->item(0)->nodeValue .
              "' target='_blank'>" .
              $y->item(0)->childNodes->item(0)->nodeValue . "</a>"; */
//$hint = $hint . '<br /><input  class="btn btn-link" type="button" value="' . $paper . '"  onClick="javascript:fileSelected(\'' . $row['id'] . '\');" />';
            $hint = $hint . $text;
        }
    }
    return $hint;
}

function listConcepts($dbc, $q) {
    $query = "SELECT * FROM def where name like '%$q%' ORDER BY name ASC";
    $data = mysqli_query($dbc, $query);
    $hint = "";

    while ($row = mysqli_fetch_array($data)) {
        $paper = $row['name'] . '.' . $row['def'] ;
        $text = '<label onClick="javascript:fileSelected(\'' . $row['name'] . '\');">' . $paper . '</label><br/>';
        if ($hint == "") {
            $hint = $text;
        } else {
            $hint = $hint . $text;
        }
    }
    return $hint;
}

function listImages($dbc, $q) {

    if (!strncmp($q, FIGURE, strlen(FIGURE))) {
        $q = substr($q, strlen(FIGURE));
    }

    $query = "SELECT * FROM images where id like '%$q%' or name like '%$q%' ORDER BY id ASC";

    $data = mysqli_query($dbc, $query);

    $hint = "";

    while ($row = mysqli_fetch_array($data)) {
        //$link = '['. FIGURE . $row['id'] . ']' . $row['name'];
        //$link = '['. FIGURE . $row['id'] . ']' . $row['name'];
        $paper = '[' . FIGURE . $row['id'] . ']' . $row['name'] . '.' . $row['description'];
        $text = '<label onClick="javascript:fileSelected(\'' . FIGURE . $row['id'] . '\');">' . $paper . '</label><br/>';
        if ($hint == "") {
            $hint = $text;
        } else {
            $hint = $hint . $text;
        }
    }
    return $hint;
}

//lookup all links from the xml file if length of q>0
if (strlen($q) > 0) {
    $hint = "";
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $text = listArticles($dbc, $q);
    if ($hint == "") {
        $hint = $text;
    } else {
        $hint = $hint . $text;
    }

    $text = listImages($dbc, $q);
    if ($hint == "") {
        $hint = $text;
    } else {
        $hint = $hint . $text;
    }
    
    $text = listConcepts($dbc, $q);
    if ($hint == "") {
        $hint = $text;
    } else {
        $hint = $hint . $text;
    }
}

// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint == "") {
    $response = "无相关资源";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>
