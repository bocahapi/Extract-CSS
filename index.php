<?php
include ('class.php');

if(isset($_POST['set'])){

$blue = new Blue_Crimson();

$file = $_FILES['upload'];

$act  = $_POST['set'];

}?>
<html>
<head>
	<title> Un/Compressing CSS </title>

<style>
	h2,.link a{color : #fff;}
	.body{
		background: #222;
		margin:0;
		padding: 0;
	}
	.container{
		width: 60%;
		margin: 10% auto;
		text-align: center;
	}
	form{
	background: none repeat scroll 0 0 #FFFFFF;
    line-height: 32px;
    padding: 10px;
    text-align: center;
	}
</style>
</head>

<body class="body">
	<div class="container">
		<h2>Blue Crimson</h2>
		<form action="" method="post" enctype="multipart/form-data">
			<label for="file">Upload Your CSS</label>
			<input type="file" name="upload"/> <br>
			<input type="radio" name="set" value="uncompress"> Uncompress
			<input type="radio" name="set" value="compress"> Compress <br>
			<button type="submit">Done</button>
		</form>
		<div class="link"><?php (isset($_POST['set'])) ? $blue->Extract($file,$act) : '' ;?></div>
		<footer> Create By <a href="http://wakhid.me">Wakhid Wicaksono</a></footer>
	</div>
</body>

</html>
