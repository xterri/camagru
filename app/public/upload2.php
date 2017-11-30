<?php
require("../includes/admin_functions.php");
require("../includes/helper.php");

// Get img array from preupload.php
$photos_uploaded = $_FILES['photo_filename'];

// check if uploaded file is a real img
	// whenever file is uploaded, php generates an array with details of the uploaded file (name, mime type, tmp location on server, file size)
// array of mime type values & their extensions, accepted in the gallery
$photo_types = array(
	'image/pjpeg'=>'jpg',
	'image/jpeg'=>'jpg',
	'image/gif'=>'gif',
	'image/bmp'=>'bmp',
	'image/x-png'=>'png'
);
$counter = 0;
// rejects file if file size < 0 bytes (ex. from empty fields)
while ($counter <= count($photos_uploaded)) {
	if ($photos_uploaded['size'][$counter] > 0) {
		// validates file's type from photo_types array
		if (!array_key_exists($photos_uploaded['type'][$counter], $photo_types))
			// render an error
			$result_final .= 'File '.($counter + 1).' is not a photo<br />';
		else {
			// file is an img, add the file
			// file = valid, index into table. add new entry to gallery_photo table
				// set default name as 0 for now, will change the filename later
			// insert uploaded file to gallery table and get file's id #  
			$new_id = add_photo_to_gallery_and_get_id('0', $_POST['category']);
			// get filetype of uploaded file
			$filetype = $photos_uploaded['type'][$counter];
			// get extension for new name
			$extension = $photo_types[$filetype];
			// generate new name and update db with new filename
			$filename = $new_id.'.'.$extension;
			update_filename($filename, $new_id);
			// upload img to img_dir (aka ../public/photos) w/ copy function
				// copy img from tmp locaton to photos directory
			// 'tmp_name' = key for the tmp location of uploaded file
				//copy($photos_uploaded['tmp_name'][$counter], $images_dir.'/'.$filename);
			// or can use the PHP 4-specific function
			move_uploaded_file($photos_uploaded['tmp_name'][$counter], $images_dir.'/'.$filename);
		}
	}
	$counter++;
}

render("main.php");

?>
