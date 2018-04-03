<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<header>';
		echo '<h1>' . $page->title() . '</h1>';
	echo '</header>';
	echo '<div class="concerts rows">';
		$concerts = $page->concerts()->toStructure()->sortBy( 'date', 'desc' );
		foreach ( $concerts as $index => $concert ) {
			echo '<div class="concert row">';
				if( $date = $concert->date( 'D, d M Y' ) ) {
					echo '<div class="title">' . $date . '</div>';	
				}
				echo '<div>' . $concert->title() . '</div>';	
			echo '</div>';
		}
		echo '</div>';
	echo '</div>';
snippet('footer')
?>