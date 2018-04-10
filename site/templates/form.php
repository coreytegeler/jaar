<?php
snippet('header');
$slug = $page->slug();
$googleScript = $site->googleScript();
echo '<div class="content form" id="' . $page->slug() . '">';
	echo '<div class="close"></div>';
	echo '<header>';
		echo '<h1>' . $page->title() . '</h1>';
		echo '<div class="subtitle">' . $page->subtitle()->kirbytext() . '</div>';
	echo '</header>';
		echo '<form id="' . $slug . '_form" autocomplete="off" novalidate data-script="' . $googleScript . '">';
			echo '<div class="field hidden">';
				echo '<input type="text" name="googleSheetId" value="' . $page->googleSheetId() . '">';
			echo '</div>';
			$fields = $page->fields()->toStructure();
			foreach( $fields as $index => $field ) {
				$type = $field->_fieldset();
				$label = $field->label();
				$sheet_label = $field->sheet_label();
				if( $sheet_label->empty() ) {
					$sheet_label = $label;
				}
				$id = preg_replace( '/[^A-Za-z0-9\-]/', '', $sheet_label );
				$options = $field->options()->split(',');
				$required = ( $field->required() == 'true' ? ' required' : '' );
				$classes = $type . $required . ( $index == sizeof( $fields ) - 1 ? ' last' : '' );
				echo '<div class="field ' . $classes . '">';
					echo '<label for="' . $id . '">' . $label . '</label>';
					if( $type == 'text' ) {
						echo '<input type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . ' autocomplete="off">';
					} else if( $type == 'textarea' ) {
						echo '<textarea name="' . $sheet_label . '" id="' . $id . '"' . $required . ' rows="4"></textarea>';
					} else if( $type == 'email' ) {
						echo '<input type="email" name="' . $label . '"' . $required . ' autocomplete="off">';
					} else if( $type == 'select' ) {

						echo '<select type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '>';
							echo '<option value=""></option>';
							foreach( $options as $index => $option ) {
								echo '<option value="' . $option . '">' . $option . '</option>';
							}
						echo '</select>';

						echo '<div class="dropdown" data-name="' . $sheet_label . '" data-id="' . $id . '" data-required="' . $required . '">';
							echo '<div class="label"></div>';
							echo '<div class="inner">';
								echo '<div class="options">';
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
			echo '<div class="thankyou">Thank you for submitting this '.$page->title().'.</div>';
			echo '<input type="submit" id="submit_' . $slug . '_form" value="Submit"/>';
		echo '</form>';
	echo '</div>';
echo '</div>';
snippet('footer');
?>