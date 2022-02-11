<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$target_file = $target_dir . uniqid() . "." . strtolower(pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

//echo uniqid() . strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
//if(isset($_POST["image"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
//}

// Check if file already exists
if (file_exists($target_file)) {
    $uploadOk = 0;
}

// Check file size
if ($_FILES["image"]["size"] > 500000) {
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<?php
    $host = "127.0.0.1";
    $port = 65432;
    // No Timeout
    set_time_limit(0);

    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
    $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");
    socket_write($socket, $target_file, strlen($target_file)) or die("Could not send data to server\n");
    $result = socket_read ($socket, 1024) or die("Could not read server response\n");
    //echo "Reply From Server  :".$result;
    socket_close($socket);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="analyze.css" rel="stylesheet">
    <title>Mushroom Detection</title>
</head>
<body style="display: flex; justify-content: center; align-items: center">
    <a class="btn btn-secondary" href="index.html" style="position: absolute; top: 10px; left: 10px">Back</a>

    <div>
        <header class="text-white text-center">
            <h1 class="display-4">Mushroom Detection</h1>
            <p class="lead mb-4">An AI which can analyze a picture and determine which type it's.</p>
        </header>
        <div class="image-area mt-4" id="imageResultContainer" style="height: 65vh">
            <img id="imageResult" src="<?php echo $target_file; ?>" alt="" class="img-fluid rounded shadow-sm mx-auto d-block" style="height: 100%;">
        </div>
        <h2 class="text-white text-center mt-2"><?php echo $result; ?></h2>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
