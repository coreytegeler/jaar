<?php
echo '<strong>' . $data->label() . '</strong>';
echo '</br>';
echo '<em>';
if( $data->sheet_label()->isNotEmpty() ) {
	echo $data->sheet_label();
} else  {
	echo $data->label();
}
echo '</em>';
?>