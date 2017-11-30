<?php
	include("config.inc.php");

	// initialization
	$photo_upload_fields = "";
	$counter = 1;

	// default number of fields
	$number_of_fields = 5; 

// If you want more fields, then the call to this page should be like, 
// preupload.php?number_of_fields=20

	if( $_GET['number_of_fields'] )
	$number_of_fields = (int)($_GET['number_of_fields']);

	// Firstly Lets build the Category List

	$result = mysql_query( "SELECT category_id,category_name FROM gallery_category" );
	while( $row = mysql_fetch_array( $result ) )
	{
$photo_category_list .=<<<__HTML_END
	<option value="$row[0]">$row[1]</option>\n
__HTML_END;
	}
	mysql_free_result( $result );	

// Lets build the Photo Uploading fields
	while( $counter <= $number_of_fields )
	{
$photo_upload_fields .=<<<__HTML_END
<tr>
	<td>
	     Photo {$counter}:
	    <input name=' photo_filename[]' type='file' />
	</td>
</tr>
<tr>
	<td>
	     Caption:
	    <textarea name='photo_caption[]' cols='30' rows='1'></textarea>
	</td>
</tr>
__HTML_END;
	$counter++;
	}

// Final Output
echo <<<__HTML_END
<html>
<head>
	<title>Lets upload Photos</title>
</head>
<body>
<form enctype='multipart/form-data' action='upload.php' method='post' name='upload_form'>
<table width='90%' border='0' align='center' style='width: 90%;'>
<tr>
	<td>
		Select Category
		<select name='category'>
			$photo_category_list
		</select>
	</td>
</tr>
<tr>
	<td>
		<p>&nbsp;</p>
	</td>
</tr>

<!-Insert the photo fields here -->
$photo_upload_fields

<tr>
	<td>
	        <input type='submit' name='submit' value='Add Photos' />
	</td>
</tr>
</table>
</form>
</body>
</html>
__HTML_END;
?>
