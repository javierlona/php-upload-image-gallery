<?php
// Namespaces define the location of class file. The 'use' statement allows us the ability to create a new object without writing the entire namespace.
use onegreatapp\UploadFile;

// Equivalent to 2MB, file size stated in bytes
$max = 2048 * 1024;

// App messages are stored in result array
$result = [];

if(isset($_POST['upload'])) {
  // Call the Upload Class
  require_once 'src/onegreatapp/UploadFile.php';

  // Set the destination where to save the uploaded files
  $destination = __DIR__ . '/src/onegreatapp/uploaded/';

  try {
    // Instantiate new object
    $upload = new UploadFile($destination);
    $upload->set_max_size($max);
    $upload->upload();
    $result = $upload->get_messages();
  } catch (Exception $e) {
    $result[] = $e->getMessage();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="ie=edge" http-equiv="X-UA-Compatible">
  <link rel="stylesheet" href="./css/style.css">
  <title>PHP File Uploads</title>
</head>
<body>
  <div class="container">
    <h1>Upload Images Form</h1>
    <?php if ($result) { ?>
    <ul>
    <?php foreach ($result as $message) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$message</li>";
    }?>
    </ul>
    <?php } ?>  
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
      <fieldset>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
          <input aria-describedby=
          "fileHelp" id="filename" type="file" name="filename[]" multiple>
          <small id="fileHelp">Only .png, .jpg, and .jpeg files allowed.</small>
        <button type="submit" name="upload">Upload File</button>
      </fieldset>
    </form>

    <div class="main-img">
      <img id="current" src="">
    </div>
    
    <div class="imgs">
      <?php 
        // Set the destination where to save the uploaded files
        $uploadFolder = __DIR__ . '/src/onegreatapp/uploaded/';
        $dir = new DirectoryIterator($uploadFolder);
        foreach ($dir as $fileinfo){
          if(!$fileinfo->isDot()){
      ?>
          <img src="<?php echo './src/onegreatapp/uploaded/' . $fileinfo->getFilename(); ?>">
            
      <?php
          };
        };
      ?>
    </div>
  </div>
  <script src="./js/script.js"></script>
</body>
</html>
