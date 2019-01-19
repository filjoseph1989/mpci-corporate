<?php # this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>MPCI CORPORATE</title>
		
		<!-- meta discriptions -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="Printing, printing, business cards, letter heads, posters">
		<meta name="description" content="MPCI Corporate is a new division of midtown which promotes different printing design services.">
		<meta name="author" content="Elman, Fil">

		<!-- style css -->
		<link href="mpci-view/style.css" rel="stylesheet" type="text/css" />
		
		<!-- Favicon -->
		<link href="mpci.ico" rel="shortcut icon" />

		
		<!-- mpci jquery -->
		<script src="mpci-view/js/feature.js"></script>
		<script src="mpci-view/js/jquery-1.11.1.min.js"></script>
		<script src="mpci-view/js/loading.js"></script>
		<script src="mpci-view/js/mpci.js"></script>
		<script src="mpci-view/js/mpci_draw.js"></script>
		<script src="mpci-view/js/product01.js"></script>
		<script src="mpci-view/js/sonic.js"></script>
		<script src="mpci-view/js/mpci_price.js"></script>
		
		<!-- <script src="mpci-view/js/mpci_admin.js"></script> -->

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<script type="text/javascript" src="mpci-tinymce/js/tinymce/tinymce.min.js"></script>
		<script>
		tinymce.init({
			selector: "textarea#elm1",
			theme: "modern",
			width:  779,
			height: 300,
			indentation : '20pt',
			plugins: [
				 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				 "save table contextmenu directionality emoticons template paste textcolor"
		   ],
		   content_css: "css/content.css",
		   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
		   style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			]
		 }); 
		</script>
	</head>
<body onload="draw()">
<div class="mpci-logo"></div>
<div class="mpci">
