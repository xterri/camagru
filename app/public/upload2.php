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

			// create thumbnails with uploaded images
			// determine if image is tall or wide with GetImageSize()
			$size = GetImageSize($images_dir.'/'.$filename);
			// calculate thumbnail size
			if ($size[0] > $size[1]) {
				// wide img
				$thumbnail_width = 100; // preset width
				$thumbnail_height = (int)(100 * $size[1] / $size[0]); // preset width * (height dim of original img / width dim of original img)
			}
			else {
				$thumbnail_width = (int)(100 * $size[0] / $size[1]); // preset height * (width dim of original img / heigh dim of original img)
				$thumbnail_height = 100; // preset height
			}
			// to create thumbnails: need img handle to read uploaded img, create another img handle to create the thumbnail, resize original img via handle, save resized img with thumbnail handle
			$gd_function_suffix = array(
				'image/pjpeg'=>'JPEG',
				'image/jpeg'=>'JPEG',
				'image/gif'=>'GIF',
				'image/bmp'=>'WBMP',
				'image/x-png'=>'PNG'
			);
			// get name suffix based on mime type
			$function_suffix = $gd_function_suffix[$filetype];
			// build function name for ImageCreateFromSUFFIX
			$function_to_read = 'ImageCreateFrom'.$function_suffix; //ImageCreateFromJPEG
			// build function name for ImageSUFFIX
			$function_to_write = 'Image'.$function_suffix; //ImageJPEG
			
			// read src file (holds info of original file size)
			$src_handle = $function_to_read($images_dir.'/'.$filename);
			// Resizing w/ GD 1.x.x >> uses ImageCreate & ImageCopyResized
				/* if ($src_handle) { */
				/* 	// create blank img for thumbnail (holds info for thumbnail size) */
				/* 	$dst_handle = ImageCreate($thumbnail_width, $thumbnail_height); */
				/* 	// resize it; arg 3-6 = coordinates for where img should be resized */
				/* 	ImageCopyResized($dst_handle, $src_handle, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $size[0], $size[1]); */
				/* } */
				/* // save thumbnail */
				/* $function_to_write($dst_handle, $images_dir.'/tb_'.$filename); */
				/* ImageDestroy($dst_handle); */
				// Resizing w/ GD 2.x.x (not restricted to 256 colors) >> uses ImageCreateTrueColor & ImageCopyResampled
			if ($src_handle) {
				// create blank img for thumbnail
				$dst_handle = ImageCreateTrueColor($thumbnail_width, $thumbnail_height);
				// resize it
				ImageCopyResampled($dst_handle, $src_handle, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $size[0], $size[1]);
			}
			// save thumbnail
			$function_to_write($dst_handle, $images_dir.'/tb_'.$filename);
		}
	}
	$counter++;
}

render("main.php");

?>
