<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<header>';
		echo '<h1>' . $page->title() . '</h1>';
	echo '</header>';
	echo '<div class="figures posters">';
		$posters = $page->files()->sortBy('sort', 'asc');
		foreach ( $posters as $index => $poster ) {
			echo '<figure class="poster">';
				echo $poster->resize(900, null, 100);;
				echo '<figcaption>' . $poster->caption()->kirbytext() . '</figcaption>';
			echo '</figure>';
		}
		echo '</div>';
	echo '</div>';
snippet('footer')
?>