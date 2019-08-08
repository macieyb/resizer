<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Image Rescale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm"></div>
        <div class="col-sm text-center">
            <form action="" method="post" enctype="multipart/form-data" id="rescale-form">
                <label for="file_width">Target width of your image (px):</label>
                <input name="width" class="form-control" placeholder="Width" type="number" id="file_width"
                       min="50" max="1920" required>
                <br>
                <label for="file_height">Target height of your image (px):</label>
                <input name="height" class="form-control" placeholder="Height" type="number" id="file_height"
                       min="50" max="1080" required>
                <br>
                <label for="file_to_upload">Select file to upload (jpg, png, gif):</label>
                <input name="file" class="form-control" type="file" id="file_to_upload" required>
                <br>
                <input class="btn-primary btn-block" type="submit" name="submit" value="Image upload">
            </form>
        </div>
        <div class="col-sm"></div>
    </div>
    <div class="row mb-3"></div>
    <div class="row">
        <div class="col"></div>
        <?php

        require __DIR__ . '/vendor/autoload.php';

        use Resizer\ImageResizer;

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit']) && is_array($_FILES["file"])) {

            try {
                $imageResizer = new ImageResizer();
            } catch (Exception $e) {
                echo ("Exception thrown: " . $e->getMessage());
            }
            $resizedImage = $imageResizer->getResizedImage($_FILES['file'], $_POST);

            echo "<div class='col-md-auto'>";
            echo "<img src={$resizedImage} alt='Resized image' id='resized-image'>";
            echo "</div>";
        }

        ?>
        <div class="col"></div>
    </div>
</div>
</body>
</html>

