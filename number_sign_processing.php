<?php

require_once('appvars.php');

function process_number_sign($in) {

    preg_match_all('/#(.*?)#/', $in, $out);
 
    $biblio = array();
    foreach ($out[1] as $word) {

        if (!strncmp($word, BIBLIO, strlen(BIBLIO))) {
            $word = substr($word, strlen(BIBLIO));
            //echo "is biblio;";
            $link = '<a href="javascript:invokePopupService(\'' . $word . '\',\'resource\');">[' . $word . ']</a>';
            $in = str_replace("#" . BIBLIO . "$word#", $link, "$in");
            array_push($biblio, $word);
        } else if (!strncmp($word, FIGURE, strlen(FIGURE))) {
            $word = substr($word, strlen(FIGURE));
            //echo "is image;";
            $link = '<a href="javascript:invokePopupService(\'' . $word . '\',\'image\');">' . FIGURE . $word . '</a>';
            $in = str_replace("#" . FIGURE . "$word#", $link, "$in");
        } else {
            $link = '<a href="javascript:invokePopupService(\'' . $word . '\');">' . $word . '</a>';
            $in = str_replace("#$word#", $link, "$in");
        }
    }
    //print_r($biblio);

    //$results["content"] = $in;
    //echo $results["content"];
    //$results[biblio] = $biblio;
    $results[content] = $in;
    $results[biblio] = $biblio;

    return $results;
}

?>
 