<div class = "booth-setup">
	<div class="drop_imgs">
       	<image id="" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
	</div>
	<div class="booth">
		<div class="vid_box">
			<video id="video" width="99%" height="99%" autoplay></video>
		</div>
		<div class="photo_capture">
			<a href="#" id="capture" class="booth-capture-button">Take photo</a>
			<form action="upload.php" method="post" enctype="multipart/form-data">
		    Select image to upload:
			<input type="file" name="fileToUpload" id="fileToUpload">
			&ensp; &ensp;
		    <input type="submit" value="Upload Image" name="submit">
			</form>
		</div>
	</div>
<!--Display (saved?) images with foreach from php -->
	<div class="thumbnails">
  		<canvas id="canvas" width="400" height="300"></canvas>
       	<image id="photo" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="photo" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="photo" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
       	<image id="photo" src="https://i.pinimg.com/originals/18/a0/a3/18a0a39e7dccffaa11fc47f8d21b54af.jpg" width="100" alt="Photo of you">
	</div>
    <script src="../public/js/photo.js"></script>
</div>
