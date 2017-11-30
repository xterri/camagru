<?php
	// automated upload form 
	require("../includes/helper.php");
	require("../includes/admin_functions.php");

	// initialization
	$photo_upload_fields = '';

	// upload more than one image => set link to:
		// '../preupload.php?number_of_fields=20'
	$number_of_fields = (isset($_GET['number_of_fields'])) ? (int)($_GET['number_of_fields']) : 5;

	// build category list
	$query = $conn->prepare("SELECT category_id, category_name FROM gallery_category");
	$query->execute();
	// get the list of categories available, save the data to use later for a drop down menu
		// in html code, only call the $photo_category_list variable and it should display the results
	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$photo_category_list[] = ["name"=>$row["category_name"],
			"id"=>$row["category_id"]];
	}
	render("preup_form.php", ["categories"=>$photo_category_list, "number_of_fields"=>$number_of_fields, "title"=>"Take a Photo"]);
?>
