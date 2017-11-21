<?php
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	// initialization
	$photo_upload_fields = '';
	$counter = 1;

	// upload more than one image => set link to:
		// '../preupload.php?number_of_fields=20'
	$number_of_fields = (isset($_GET['number_of_fields'])) ? (int)($_GET['number_of_fields']) : 1;

	// build category list
	$query = $conn->prepare("SELECT category_id, category_name FROM gallery_category");
	$query->execute();
	// get the list of categories available, save the data to use later for a drop down menu
		// in html code, only call the $photo_category_list variable and it should display the results
	while ($row = $query->fetch(PDO::FETCH_ASSOC))
	{
		// concat onto $photo_category_list to display/get each category in the list
		$photo_category_list .= <<<__HTML_END <option value="$row[0]">$row[1]</option>n __HTML_END;
	}

	// build image uploading fields
?>
