<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-white bg-dark">Registerd Name with Profile</h1>
        <br>
        <div class="table-responsive"></div>
        <table  class="table table-bordered table-striped table-hover">
            <thead>
                <th>Id</th>
                <th>Username</th>
                <th>Profile Pic</th>
                <tbody>
                    <?php
                    require 'connection.php';
                    // if(isset($_POST['submit'])){
                    //     $username = $_POST['username'];
                    //     $files = $_FILES['file'];
                    //     print_r($username);
                    //     echo "<br>";
                    //     // print_r($files);

                    //     $filename = $files['name'];
                    //     print_r($filename);
                    //     $fileerror = $files['error'];
                    //     $filetmp = $files['tmp_name'];
                    //     print_r($filetmp);

                    //     //to check the image format 
                    //     $fileext = explode('.',$filename);
                    //     $filecheck = strtolower(end($fileext));
                    //     $fileextstored = array('png','jpg','jpeg');
                    //     if(in_array($filecheck,$fileextstored)){
                    //         echo "check";
                    //         $destinationfile = '/opt/lampp/htdocs/Insert Image/uploads';
                    //        if(move_uploaded_file($filetmp,"$destinationfile/$filename")){
                    //            echo "file uploaded";
                    //        }else
                    //        echo "no file uploaded";
                           
                    //     };

                    // }
                    // Checking weather it is a valid request or not
if(isset($_POST['submit'])){
    $userName = $_POST['username'];
    //Taking the files from input
    $file = $_FILES['file'];
    //Getting the file name of the uploaded file
    $fileName = $_FILES['file']['name'];
    //Getting the Temporary file name of the uploaded file
    $fileTempName = $_FILES['file']['tmp_name'];
    //Getting the file size of the uploaded file
    $fileSize = $_FILES['file']['size'];
    //getting the no. of error in uploading the file
    $fileError = $_FILES['file']['error'];
    //Getting the file type of the uploaded file
    $fileType = $_FILES['file']['type'];

    //Getting the file ext
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    //Array of Allowed file type
    $allowedExt = array("jpg","jpeg","png","pdf");

    //Checking, Is file extentation is in allowed extentation array
    if(in_array($fileActualExt, $allowedExt)){
        //Checking, Is there any file error
        if($fileError == 0){
            //Checking,The file size is bellow than the allowed file size
            if($fileSize < 10000000){
                //Creating a unique name for file
                $fileNemeNew = uniqid('',true).".".$fileActualExt;
                //File destination
                $fileDestination = 'uploads/'.$fileNemeNew;
                //function to move temp location to permanent location
                if(move_uploaded_file($fileTempName, $fileDestination)){
                    echo "File Uploaded successfully";

                    $q = "INSERT INTO `imgupload` (`username`,`image`) VALUES ('$userName','$fileDestination')";
                    $query = mysqli_query($conn,$q);

                    $displayquery = "select * from imgupload";
                    $querydisplay = mysqli_query($conn,$displayquery);

                    // $row = mysqli_num_rows($querydisplay);
                    while($result = mysqli_fetch_array($querydisplay) ){
                        ?>
                        <tr>
                            <td><?php echo $result['id'];?></td>
                            <td><?php echo $result['username'];?></td>
                            <td> <img src="<?php echo $result['image'];?>"
                            height="100px" width="100px"></td>

                        </tr>
                        <?php
                    }
                }else
                echo "failed to upload image";
                //Message after success
               
            }else{
                //Message,If file size greater than allowed size
                echo "File Size Limit beyond acceptance";
            }
        }else{
            //Message, If there is some error
            echo "Something Went Wrong Please try again!";
        }
    }else{
        //Message,If this is not a valid file type
        echo "You can't upload this extention of file";
    }
}


                    ?>
                </tbody>
            </thead>
        </table>
    </div>
</body>
</html>