<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<header>';
		echo '<h1>' . $page->title() . '</h1>';
		snippet('player');
	echo '</header>';
	echo '<div class="figures discography">';
		$albums = $page->children()->sortBy('sort', 'asc');
		foreach ( $albums as $index => $album ) {
			$image = $album->files()->filterBy('type', 'image')->first()->resize(900, null, 100);
			$tracks = $album->files()->filterBy('type', 'audio')->sortBy('sort', 'asc');
			echo '<figure class="image">';
				echo $image;
			echo '</figure>';
			echo '<figure class="tracklist">';
				echo '<ul>';
					echo '<li class="album_title">' . $album->title() . '</li>';
					foreach ( $tracks as $index => $track ) {
						echo '<li class="track_name">';
							echo '<a class="track" href="' . $track->url() . '">' . $track->trackname() . '</a>';
						echo '</li>';
					}
				echo '</ul>';
			echo '</figure>';
		}
	echo '</div>';
	echo js('assets/js/audio.min.js');
	echo js('assets/js/app.min.js');
echo '</div>';
snippet('footer');
?>