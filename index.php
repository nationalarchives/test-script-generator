<!DOCTYPE html>
<?php 
require_once('data.php'); 
require_once('logic.php');
?>	

<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>Testing</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://bootswatch.com/readable/bootstrap.min.css">
</head>
<body>

	<div class="container">	
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h1>Browser testing</h1>
				</div>
				<ul class="list-group">
				 <?php 
				 	generateTestScript($testers, $pages, $pagesAlwaysTested); 
				 ?>
				</ul>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
</body>
</html>