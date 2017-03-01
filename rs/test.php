<!DOCTYPE html>
<html> 
<head>
<meta charset="utf-8">
<title>test</title> 

</head>
<body>

<?="Brno: ".md5("Code1152")."<br>"?>
<?="Olomouc: ".md5("Code1353")."<br>"?>
<?="Ostrava: ".md5("Code1551")."<br>"?>
<?="Plzen: ".md5("Code1331")."<br>"?>
<?="Pavlovsky: ".md5("Knihomol17")."<br>"?>
<?="Irena: ".md5("Jsinejlepsianejuzasnejsi1")."<br>"?>


<div id="main">

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.friendurl.js"></script>
<script src="js/string2seo.js"></script> 

<script>

$(function(){
	$('#title1').friendurl({id : 'link1', divider: '-', transliterate: true});
});

</script>


		<form action="index.html" method="get">
			<label for="title1">Title</label><br />
			<input type="text" name="title1" id="title1" style="width: 400px" /><br />
			<label for="link1">Friendly URL</label><br />
			<input type="text" name="link1" id="link1" style="width: 400px" readonly="readonly" />
		</form>

</div>
</body>
</html>
