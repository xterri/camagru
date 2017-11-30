<form enctype="multipart/form-data" action="upload2.php" method="post" name="upload_form">
	<table width="90%" border="0" align="center" style="width: 90%;">
	<tr><td>
	Select Category
	<select name="category">
	<?php
	if (is_array($categories)) {
		foreach($categories as $category) {
			print('<option value="'.$category["id"].'">'.$category["name"].'</option>');
		}
	}
	$counter = 1;
	while ($counter <= $number_of_fields) {
		print('<tr><td>Photo '.$counter.': <input name="photo_filename[]" type="file" /></td></tr>');
		$counter++;
	}
	?>
	</select>
	</td></tr>
<!-- Insert image fields here -->
	<tr><td>
		<input type="submit" name="submit" value="Add Photos" />
	</td></tr>
	</table>
</form>
