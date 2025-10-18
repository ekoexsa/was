<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>Image Gallery</h1>
            <a href="index.php">Home</a>
        </header>

        <main>
            <div class="gallery">
                <?php
                $images = glob('assets/images/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach($images as $image){
                    echo '<img src="' . $image . '" alt="Gallery Image">';
                }
                if (empty($images)) {
                    echo '<p>No images found in the gallery.</p>';
                    echo '<img src="assets/images/placeholder_image.png" alt="Placeholder Image" style="width:100px;height:100px;">';
                }
                ?>
            </div>
        </main>
    </div>

</body>
</html>