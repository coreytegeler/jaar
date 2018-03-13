<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<h1>' . $page->title() . '</h1>';
	echo '<div class="concerts">';
		$concerts = $page->concerts()->toStructure();
		foreach ( $concerts as $index => $concert ) {
			echo '<div class="concert">';
				if( $date = $concert->date( 'D, d M Y' ) ) {
					echo '<div class="date">' . $date . '</div>';	
				}
				echo '<div>' . $concert->title() . '</div>';	
			echo '</div>';
		}
		echo '</div>';
	echo '</div>';
snippet('footer')
?>