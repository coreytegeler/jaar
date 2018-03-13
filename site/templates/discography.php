<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<h1>' . $page->title() . '</h1>';
	snippet('player');
	echo '<div class="figures">';
		$albums = $page->children()->sortBy('sort', 'asc');
		foreach ( $albums as $index => $album ) {
			$image = $album->files()->filterBy('type', 'image')->first();
			$tracks = $album->files()->filterBy('type', 'audio')->sortBy('sort', 'asc');
			echo '<figure class="album">';
				echo $image;
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