<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["category"]) && isset($_POST["description"]) && isset($_FILES["file"])) {
    $title = $_POST["title"];
    $category = $_POST["category"];
    
    // Trim the description to remove any leading or trailing whitespace
    $description = trim($_POST["description"]);

    // Remove extra new lines or whitespace at the beginning of the description
    $description = ltrim($description);

    $file = $_FILES["file"];

    // Check if the file upload was successful
    if ($file["error"] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        exit();
    }

    // Directory where subjects folders are located
    $subjectsDirectory = "subjects/";

    // Create a folder for the specific subject if it doesn't exist
    if (!file_exists($subjectsDirectory . $category)) {
        mkdir($subjectsDirectory . $category, 0777, true);
    }

    // Create a folder for the specific course using the course title
    $courseFolder = $subjectsDirectory . $category . "/" . preg_replace('/[^a-zA-Z0-9-_]/', '_', $title) . "/";
    if (!file_exists($courseFolder)) {
        mkdir($courseFolder, 0777, true);
    }

    // Move uploaded file to the course's folder
    $targetFile = $courseFolder . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
        
        // Save title and description to a text file
        $infoFile = $courseFolder . "info.txt";
        $infoContent = "Title: " . $title . "\nDescription: " . $description;
        file_put_contents($infoFile, $infoContent);

        echo "<br>Title and description saved.";
        header("Location: home.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
        header("Location: home.php");
    }
}
?>
