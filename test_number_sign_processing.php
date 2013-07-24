<?php

include_once ("./header.php");

require_once('appvars.php');
require_once('connectvars.php');
include_once ("./pop_up.php");
include_once ("./number_sign_processing.php");

$in = "<p>#文献Berners-Lee2006a##图表70##乙肝#我国于2006年进行的乙型肝炎流行病毒我国于2006年进行的乙型肝炎流行病毒调查结果表明，我国1-59人群乙肝表面抗原携带率为7.18%，5岁以下儿童的HBsAg携带率仅为0.96%，据此推算，我国现有的慢性HBV感染者约9300万人，其中有症状需要治疗的活动性乙型肝炎患者约为2000多万。</p>";

echo process_number_sign($in) . '<br>';
//echo $in;
include_once ("./foot.php");
?>
 