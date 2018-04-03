<?php
snippet('header');
echo '<div class="content" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<header>';
		echo '<h1>' . $page->title() . '</h1>';
	echo '</header>';
	echo '<div class="postings rows">';
		$postings = $page->postings()->toStructure()->sortBy( 'date', 'desc' );
		foreach ( $postings as $index => $posting ) {
			echo '<div class="posting row">';
				echo '<div class="title">' . $posting->title() . '</div>';	
				if( $date = $posting->date( 'D, d M Y' ) ) {
					echo '<em class="date">Posted on ' . $date . '</em>';	
				}
				echo '<div class="text">' . $posting->text()->kirbytext() . '</div>';	
			echo '</div>';
		}
		echo '</div>';
	echo '</div>';
snippet('footer')
?>