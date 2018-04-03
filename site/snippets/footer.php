<?php if( !isset( $_POST['request'] ) ) { ?>
</div>
</main>
</body>
<?php
$version = 2.1;
echo css('assets/css/player.css');
echo css('assets/css/style.css?v='.$version);
echo js('assets/js/jquery-3.3.1.min.js');
echo js('assets/js/jquery-ui.min.js');
echo js('assets/js/moment.js');
echo js('assets/js/scripts.js?v='.$version);
?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-5354079-21', 'auto');
	ga('send', 'pageview');
</script>
</html>
<?php } ?>