<?php snippet('header') ?>

  <main class="main" role="main">
<?php
  $slug = $page->slug();
  if( $slug == 'home') {
    $slug = 'booking';
    $page = page( $slug );
  }
  echo '<form id="' . $slug . '_form">';
    echo '<h1>' . $page->title() . '</h1>';
    echo '<h2>' . $page->subtitle() . '</h2>';
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
      // $required = ( $field->required() == 'true' ? ' required' : '' );
      $required = ' required';

      echo '<div class="field ' . $type . $required . '">';
        echo '<label for="' . $id . '">' . $label . '</label>';
        if( $type == 'text' ) {
          echo '<input type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '">';
        } else if( $type == 'email' ) {
          echo '<input type="email" name="' . $label . '"' . $required . '>';
        } else if( $type == 'select' ) {
          echo '<select type="text" name="' . $sheet_label . '" id="' . $id . '"' . $required . '">';
            echo '<option value=""></option>';
            foreach( $options as $index => $option ) {
              echo '<option value="' . $option . '">' . $option . '</option>';
            }
          echo '</select>';
        } else if( $type == 'date' ) {
          echo '<input type="date" name="' . $sheet_label . '" id="' . $id . '"' . $required . '">';
        } else if( $type == 'radio' ) {
          foreach( $options as $index => $option ) {
            $option_id = $label . '_' . $option;
            echo '<input type="radio" name="' . $sheet_label . '" id="' . $option_id . '" value="' . $id  . '">';
            echo '<label for="' . $option_id . '">' . $option . '</label>';
          }
        }
      echo '</div>';

      if( $type == 'email' ) {
        echo '<div class="field email verify required">';
          echo '<label>Verify ' . $label . '</label>';
          echo '<input type="email" class="verify" name="verify-' . $label . '"' . $required . '>';
        echo '</div>';
      }

    }
    echo '<input type="submit" id="submit_' . $slug . '_form"/>';
  echo '</form>';
  ?>
  </main>

<?php snippet('footer') ?>