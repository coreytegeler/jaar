<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<div class="figures">';
		$posters = $page->files()->sortBy('sort', 'asc');
		foreach ( $posters as $index => $poster ) {
			echo '<figure class="poster">';
				echo $poster;
				echo '<figcaption>' . $poster->caption()->kirbytext() . '</figcaption>';
			echo '</figure>';
		}
		echo '</div>';
	echo '</div>';
snippet('footer')
?>