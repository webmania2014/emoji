<!DOCTYPE html>
<html>
	<head>
		<script type = 'text/javascript' src = 'jquery-1.10.2.js'></script>
		<script type = 'text/javascript' src = 'jquery.Ajax.js'></script>
	</head>
	<body>
		<form id = 'submitForm' name = 'submitForm' method = post action = 'send_post.php'>
			<input type = 'text' id = 'counter' name = 'counter' value = ''>
			<input type = 'button' value = 'submit' onclick = 'javascript:sendRequest( 1000 );'>
		</form>
	</body>
	<script>
		var counter = 0;
		$(document).ready(function(){
			$('#submitForm').ajaxForm({
				success: function(ret)
				{
					counter ++;
					$('#counter').val( counter );
				}
			});
		});

		function sendRequest( n )
		{
			for (var i = 0; i < n; i ++ )
			{
				$('#submitForm').submit();
			}
		}
	</script>
</html>