<?php
$file = "img/Hamster-Playing-Golf.jpg";
if (!unlink($file)) {
　　echo ("Error deleting $file");
} else {
echo ("Deleted $file");
}
?>
