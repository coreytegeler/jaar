<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<h1>' . $page->title() . '</h1>';
	echo '<div>' . $page->text()->kirbytext() . '</div>';
echo '</div>';
snippet('footer');
?>