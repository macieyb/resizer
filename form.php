<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Image Rescale</title>-->
<!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"-->
<!--          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">-->
<!--</head>-->
<!--<body>-->
<!--<div class="container">-->
<!--    <label for="rescale-form" class="col-sm-2 col-form-label">Rescale Image Form</label>-->
<!--    <form action="form.php" method="post" class="md-form" id="rescale-form">-->
<!--        <div class="input-group mb-3">-->
<!--            <div class="input-group-prepend">-->
<!--                <span class="input-group-text" id="input-width">Target width of image (px):</span>-->
<!--            </div>-->
<!--            <input name="width" type="number" class="form-control" placeholder="Width">-->
<!--        </div>-->
<!--        <div class="input-group mb-3">-->
<!--            <div class="input-group-prepend">-->
<!--                <span class="input-group-text" id="input-height">Target height of image (px):</span>-->
<!--            </div>-->
<!--            <input name="height" type="number" class="form-control" placeholder="Height">-->
<!--        </div>-->
<!--        <div class="input-group mb-3">-->
<!--            <div class="input-group-prepend">-->
<!--                <span class="input-group-text" id="input-file">Select file to upload:</span>-->
<!--            </div>-->
<!--            <div class="custom-file">-->
<!--                <input name="file" type="file" class="custom-file-input" id="input-file-upload">-->
<!--                <label class="custom-file-label" for="input-file-upload">Image</label>-->
<!--            </div>-->
<!--        </div>-->
<!--      Image Rescale  <div class="row justify-content-center">-->
<!--            <div class="col-md-6">-->
<!--                <input type="submit" name="submit" class="btn btn-primary btn-block">Submit</input>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
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

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require __DIR__ . '/vendor/autoload.php';

        use Resizer\ImageResizer;

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit']) && is_array($_FILES["file"])) {
            $imageResizer = new ImageResizer();
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

