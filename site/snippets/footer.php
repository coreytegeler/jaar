<?php if( !isset( $_POST['request'] ) ) { ?>
</div>
</main>
</body>
<?php
$version = 1.3;
echo css('assets/css/player.css');
echo css('assets/css/style.css?v='.$version);
echo js('assets/js/jquery-3.3.1.min.js');
echo js('assets/js/jquery-ui.min.js');
echo js('assets/js/moment.js');
echo js('assets/js/scripts.js?v='.$version);
?>
</html>
<?php } ?>