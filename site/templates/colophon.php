<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<div>' . $page->text()->kirbytext() . '</div>';
echo '</div>';
snippet('footer');
?>