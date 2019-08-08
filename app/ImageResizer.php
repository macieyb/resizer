<?php

namespace Resizer;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use DateTime;
use Exception;

class ImageResizer
{
    const NEW_FILE_PATH = "upload/resizedImg.";

    public function __construct()
    {
        if (!file_exists('logs')) {
            if (!mkdir('logs', 0777, true)) {
                throw new Exception("Cannot create logs directory, check your file permissions on resizer app dir.");
            };
        }
        if (!file_exists('upload')) {
            if (!mkdir('upload', 0777, true)) {
                throw new Exception("Cannot create logs directory, check your file permissions on resizer app dir.");
            };
        }
    }

    public function getResizedImage($filesData, $postData)
    {
        $file = $filesData['tmp_name'];
        $uploadedFileData = getimagesize($file);
        $ext = pathinfo($filesData['name'], PATHINFO_EXTENSION);

        switch ($ext) {
            case "png":
                $newImageFromFile = imagecreatefrompng($file);
                $targetImage = $this->imageResize($newImageFromFile, $postData['width'], $postData['height'], $uploadedFileData[0], $uploadedFileData[1]);
                imagepng($targetImage, self::NEW_FILE_PATH . $ext);
                break;
            case "gif":
                $newImageFromFile = imagecreatefromgif($file);
                $targetImage = $this->imageResize($newImageFromFile, $postData['width'], $postData['height'], $uploadedFileData[0], $uploadedFileData[1]);
                imagegif($targetImage, self::NEW_FILE_PATH . $ext);
                break;
            case "jpg":
                $newImageFromFile = imagecreatefromjpeg($file);
                $targetImage = $this->imageResize($newImageFromFile, $postData['width'], $postData['height'], $uploadedFileData[0], $uploadedFileData[1]);
                imagejpeg($targetImage, self::NEW_FILE_PATH . $ext);
                break;
            default:
                echo "Not recognized file type";
                exit;
                break;
        }

        $this->logAction($filesData, $uploadedFileData);
        return self::NEW_FILE_PATH . $ext;
    }

    private function imageResize($newImageFromFile, $targetWidth, $targetHeight, $width, $height)
    {
        $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($targetImage, $newImageFromFile, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        return $targetImage;
    }

    private function logAction($filesData, $uploadedFileData)
    {
        $date = new DateTime('NOW');
        $logger = new Logger('resize_history');
        $logger->pushHandler(new StreamHandler('logs/resize_history.log', Logger::INFO));
        $logger->addInfo('Resizing new image',
            [
                'file_name' => $filesData['name'],
                'file_size' => $filesData['size'],
                'img_width' => $uploadedFileData[0],
                'img_height' => $uploadedFileData[1],
                'resize_time' => $date->format('Y-m-d H:i:s'),
            ]
        );
    }
}
