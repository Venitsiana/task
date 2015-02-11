<?php
function __autoload($class_name)
{
	include $class_name. '.php';
}
?>

<?php echo "git flow" ?>
<html>
  <head>
    <title>Pictures gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link rel="stylesheet" type="text/css" href="style.css">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript" type="text/javascript"></script>
        <script src="http://thecodeplayer.com/uploads/js/jquery-1.7.1.min.js" type="text/javascript"></script> 		
		<script>
			
			$(function() {
				$('.picture_link').click(function() {				
					$('#content').load(this.href+' #content');
					$("#content").css("margin-left","0");
					Comment();
					return false;					
				});
				
			});
			
			function showComments(){

				var allComment = "";
					$.ajax({
						url: 'Ajax.php',
						type: 'POST',
						dataType: 'json',
						data: {
							task: "showcomment"											
						},
						success: function(responce){
						
							var j = Object.keys(responce).length;
							
							for(var i=1; i <= j/2; i++){
								var name = responce['name'+i];
								var comment = responce['comment'+i];
								
								if(allComment.indexOf(name) == -1){
									allComment += "</p>";  
								} 
								if(allComment.indexOf(name) == -1){
									allComment += "<div>" + name + " comments </div><p> " + comment;
								} 
								else{									
									allComment += "<br>" + comment;
	
								} 
								
						    };

							$('#accordion').html(allComment);
							
								$('div').click(function(){
									
									$(this).parent().children('p').slideUp();	     
									if(!$(this).next().is(":visible"))
									{
									   $(this).next().slideDown();
									}
								 });
													
						},
						error: function( jqXHR, textStatus, errorThrown )
						{
							alert(errorThrown);
						},
						
					});
						
			}
			
			
			$(document).ready(function Comment(){
				
				showComments();
				
						$("#submit").click(function(){
							var name = $("#name").val().trim();
							var comment = $("#comment").val().trim();

							if(name == "" || comment == ""){
								$('#errorMsg').css("visibility", "visible");
							}else{
								
								$('#errorMsg').css("visibility", "hidden");
								
								$.ajax({
									url: 'Ajax.php',
									type: 'POST',
									dataType: 'json',
									data: {
										name: name,
										comment: comment										
									},
									success: function(){
	
										showComments();
										name = $("#name").val('');
										comment = $("#comment").val('');
														
									},
									error: function( jqXHR, textStatus, errorThrown )
									{
										alert(errorThrown);
									},
									
								});
							}
						});
						
				});
			
			</script>
  </head>
  <body>
  		<div id="container">
		<div id="menu">
			<a href="?id=1" class="picture_link">Picture 1</a>
			<a href="?id=2" class="picture_link">Picture 2</a>
			<a href="?id=3" class="picture_link">Picture 3</a>
		</div>
		
		<div id="content">
			<?php
			try{
			if(!isset($_GET['id'])){
				$id=1;
			}else{
				$id=$_GET['id'];
			}
			//$db = new mysqli('localhost','edgesoft_task4','qwelkj494','edgesoft_task4'); */
			//$db = new mysqli('localhost','root','','edgesoft_task4');
			//$query = "SELECT * FROM pictures WHERE id=".$id;
			//$result = $db->query($query)->fetch_assoc();
				
				$connection = DBConnection::getDBConnection();
				
				$statement = "SELECT * FROM pictures WHERE id=".$id;
				
				$stmt = $connection->prepare($statement);
				$stmt->execute();
				$result = $stmt->fetch();?>
			
				<img class="img-rounded" src="<?php echo $result['name'];?>" />	
					<?php 
					echo '<form method="POST" role="form">

  							<div class="form-group">
      
								<input type="text/plain" class="form-control" name="name" id="name" value="" placeholder= "Your Name"/>
							</div>
  							
  							<div class="form-group">
								<textarea class="form-control" name="comment" id="comment" value="" rows=3 cols= 10 placeholder= "Your Comment"></textarea>
							<span id="errorMsg">*Please fill all fields</span>
  							</div>	
  		  					
							<input type="button" class="btn btn-info" name ="submit" value="submit" id="submit"/>
						  </form>';
			}
			catch (PDOException $e)
			{
				echo $e->getMessage();
			}
			?>
							
		</div>
		
		<div id="accordion"></div>
		</div>
		
		
  </body>
  	
</html>
