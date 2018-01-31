<?php snippet('header') ?>

  <main class="main" role="main">
<?php
  $slug = $page->slug();
  if( $slug == 'home') {
    $slug = 'booking';
    $page = page( $slug );
  }

  echo '<form id="' . $slug . '_form">';
    $fields = $page->fields();
    foreach( $fields->toStructure() as $index => $field ) {
      $type = $field->_fieldset();
      $label = $field->label();
      $sheet_label = $field->sheet_label();
      $options = $field->options()->split(',');
      $required = ( $field->required() ? 'required' : '' );

      echo '<div class="field ' . $type . '">';
        echo '<label for="' . $sheet_label . '">' . $label . '</label>';
        if( $type == 'text' ) {
          echo '<input type="text" name="' . $sheet_label . '" id="' . $sheet_label . '" required="' . $required . '">';
        } else if( $type == 'email' ) {
          echo '<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$" name="' . $sheet_label . '" id="' . $sheet_label . '" required="' . $required . '">';
        } else if( $type == 'select' ) {
          echo '<select type="text" name="' . $sheet_label . '" id="' . $sheet_label . '" required="' . $required . '">';
            echo '<option value="null">Select type</option>';
            foreach( $options as $index => $option ) {
              echo '<option value="' . $option . '">' . $option . '</option>';
            }
          echo '</select>';
        } else if( $type == 'date' ) {
          echo '<input type="date" name="' . $sheet_label . '" id="' . $sheet_label . '" required="' . $required . '">';
        } else if( $type == 'radio' ) {
          foreach( $options as $index => $option ) {
            $id = $sheet_label . '_' . $option;
            echo '<input type="radio" name="' . $sheet_label . '" id="' . $id . '" value="' . $id  . '">';
            echo '<label for="' . $id . '">' . $option . '</label>';
          }
        }
      echo '</div>';

      if( $type == 'email' ) {
        echo '<div class="field verify_email email">';
          echo '<label>Verify ' . $label . '</label>';
          echo '<input type="email" class="verify" name="verify_' . $sheet_label . '" required="' . $required . '">';
        echo '</div>';
      }

    }
    echo '<input type="submit" id="submit_' . $slug . '_form"/>';
  echo '</form>';
  ?>
  </main>

<?php snippet('footer') ?>