<?php # this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>
<div><!-- end of .mcpi -->


<!-- jQuery -->
<script src="mpci-view/js/jquery-1.11.1.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.min.js">\x3C/script>')</script>

<!-- FlexSlider -->
<script defer src="mpci-view/js/jquery.flexslider.js"></script>
<script type="text/javascript">
	$(window).load(function() {
		$('.flexslider').flexslider({
			animation: "slide"
		});
	});
</script>

<!-- google map js -->
<script src="mpci-view/js/mpci_script.js"  type="text/javascript"></script>

</body>
</html>
