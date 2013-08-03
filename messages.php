<?php

function render_warning($warning) {
    echo '<div class = "alert"><button type = "button" class = "close" data-dismiss = "alert">&times;</button>' . $warning .
    '</div>';
}
?>
 