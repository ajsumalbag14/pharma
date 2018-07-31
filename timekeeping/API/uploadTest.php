This is a sample page for uploading images and retrieving images in the database. 
<?php

/*
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "prosel";
*/

    $host = "us-cdbr-iron-east-05.cleardb.net";
    $user = "bd219492550e73";
    $password = "0e09a57a";
    $database = "heroku_2414f0f6e111aa2";

    $conn = mysqli_connect($host, $user, $password, $database);

    /*
    1. steps - check if the upload is valid image file
    2. insert into database
    3. 
    */

    if(isset($_FILES['image'])) {
    
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $fileType = $check["mime"];
            echo "File is an image - " . $check["mime"] . ".";
            
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            $query = "INSERT INTO IMAGE_TEST (IMAGE, IMAGE_TYPE) VALUES ('$imgContent', '$fileType')";
            mysqli_query($conn, $query);

            echo 'image uploaded successfully';
        }
         else {
            echo "File is not an image.";
         }
    }

    //RETRIEVING RECORDS FROM DATABASE

    //$query = "SELECT * FROM IMAGE_TEST";
    $query = "SELECT * FROM DOCTOR_VISIT";
    
    $result = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($result)) {

    //$photo = $row['IMAGE'];
    $photo = $row['DOCTOR_SIGNATURE'];
    $fileType = $row['DOCTOR_SIGNATURE_FILE_TYPE'];

    echo '<img src="data:image/png;base64,'.base64_encode($photo).'"/>';
    //echo '<img src="data:".$fileType.";base64,'.base64_encode($photo).'"/>';
    }
?>