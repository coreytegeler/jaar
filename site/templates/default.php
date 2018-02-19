<?php snippet('header') ?>

	<main class="main" role="main">
<?php
	$slug = $page->slug();
	if( $slug == 'home') {
		$slug = 'booking';
		$page = page( $slug );
	}
	echo '<form id="' . $slug . '_form" autocomplete="off" novalidate>';
		echo '<h1>' . $page->title() . '</h1>';
		echo '<h2>' . $page->subtitle()->kirbytext() . '</h2>';
		$fields = $page->fields();
		foreach( $fields->toStructure() as $index => $field ) {
			$type = $field->_fieldset();
			$label = $field->label();
			$sheet_label = $field->sheet_label();
			if( $sheet_label->empty() ) {
				$sheet_label = $label;
			}
			$id = preg_replace( '/\s+/', '', $sheet_label );
			$options = $field->options()->split(',');
			$required = ( $field->required() == 'true' ? ' required' : '' );

			echo '<div class="field ' . $type . $required . '">';
				echo '<label for="' . $id . '">' . $label . '</label>';
				if( $type == 'text' ) {
					echo '<input type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '" autocomplete="off">';
				} else if( $type == 'textarea' ) {
					echo '<textarea name="' . $sheet_label . '" id="' . $id . '"' . $required . '" rows="4"></textarea>';
				} else if( $type == 'email' ) {
					echo '<input type="email" name="' . $label . '"' . $required . ' autocomplete="off">';
				} else if( $type == 'select' ) {

					echo '<select type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '">';
						echo '<option value=""></option>';
						foreach( $options as $index => $option ) {
							echo '<option value="' . $option . '">' . $option . '</option>';
						}
					echo '</select>';

					echo '<div class="dropdown" data-name="' . $sheet_label . '" data-id="' . $id . '" data-required="' . $required . '">';
						echo '<div class="label"></div>';
						echo '<div class="inner">';
							echo '<div class="options content">';
								echo '<div class="option" data-value=""></div>';
								foreach( $options as $index => $option ) {
									echo '<div class="option" data-value="' . $option . '">' . $option . '</div>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';

				} else if( $type == 'date' ) {
					echo '<input type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '">';
					echo '<div class="dropdown" data-name="' . $sheet_label . '" data-id="' . $id . '" data-required="' . $required . '">';
						echo '<div class="label"></div>';
						echo '<div class="inner">';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';

			if( $type == 'email' ) {
				echo '<div class="field email verify required">';
					echo '<label>Verify ' . $label . '</label>';
					echo '<input type="email" class="verify" name="verify-' . $label . '"' . $required . '>';
				echo '</div>';
			}

		}
		echo '<ul class="errors">';
			echo '<li>ERRORS:</li>';
			echo '<li class="error" id="invalidEmail">INVALID EMAIL ADDRESS.</li>';
			echo '<li class="error" id="unverifiedEmail">PLEASE VERIFY EMAIL ADDRESS.</li>';
			echo '<li class="error" id="requiredField">ALL REQUIRED FIELDS ARE NOT FILLED IN.</li>';
		echo '</ul>';
		echo '<input type="submit" id="submit_' . $slug . '_form"/>';
	echo '</form>';
	?>
	</main>

<?php snippet('footer') ?>