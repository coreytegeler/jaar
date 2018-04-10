<?php if( !isset( $_POST['request'] ) ) { ?>
</div>
</main>
</body>
<?php
$version = 2.6;
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

<!-- Default Statcounter code for my website
http://nicolasjaar.net/ -->
<script type="text/javascript">
var sc_project=11676135; 
var sc_invisible=1; 
var sc_security="0be99db8"; 
</script>
<script type="text/javascript"
src="https://www.statcounter.com/counter/counter.js"
async></script>
<noscript><div class="statcounter"><a title="Web Analytics
Made Easy - StatCounter" href="http://statcounter.com/"
target="_blank"><img class="statcounter"
src="//c.statcounter.com/11676135/0/0be99db8/1/" alt="Web
Analytics Made Easy - StatCounter"></a></div></noscript>
<!-- End of Statcounter Code -->
</html>
<?php } ?>