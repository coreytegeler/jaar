<?php snippet('header') ?>

  <main class="main" role="main">


  <form id="booking_form">
  <?php

  $booking = page( 'booking' );
  $fields = $booking->fields();
  
  foreach( $fields->toStructure() as $index => $field ) {
    $type = $field->_fieldset();
    $label = $field->label();
    $sheet_label = $field->sheet_label();
    $options = $field->options()->split(',');

    echo '<div class="field ' . $type . '">';
      echo '<label>' . $label . '</label>';
      if( $type == 'text' ) {
        echo '<input type="text" name="' . $sheet_label . '">';
      } else if( $type == 'select' ) {
        echo '<select type="text" name="' . $sheet_label . '" required>';
          echo '<option value="null">Select type</option>';
          foreach( $options as $index => $option ) {
            echo '<option value="' . $option . '">' . $option . '</option>';
          }
        echo '</select>';
      }
    echo '</div>';
  }

  ?>
    <input type="submit" id="submit_booking_form"/>
   </form>

  </main>

<?php snippet('footer') ?>