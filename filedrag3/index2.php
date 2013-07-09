<?php
if(isset($_POST['start_upload']) && $_FILES['txt_file']['name'] != ""){
     
    $local_file = $_FILES['txt_file']['tmp_name']; // Defines Name of Local File to be Uploaded

    $destination_file = "/".basename($_FILES['txt_file']['name']);  // Path for File Upload (relative to your login dir)

    // Global Connection Settings
    $ftp_server = "valentin-thulliez.com";      // FTP Server Address (exlucde ftp://)
    $ftp_user_name = "u67776459";     // FTP Server Username
    $ftp_user_pass = "lorcomlier80";      // Password

    // Connect to FTP Server
    $conn_id = ftp_connect($ftp_server);
    // Login to FTP Server
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
    
    // Verify Log In Status
    if ((!$conn_id) || (!$login_result)) {
        echo "FTP connection has failed! <br />";
        echo "Attempted to connect to $ftp_server for user $ftp_user_name";
        exit;
    } else {
        echo "Connected to $ftp_server, for user $ftp_user_name <br />";
    }

    $upload = ftp_put($conn_id, $destination_file, $local_file, FTP_BINARY);  // Upload the File
    
    // Verify Upload Status
    if (!$upload) {
        echo "<h2>FTP upload of ".$_FILES['txt_file']['name']." has failed!</h2><br /><br />";
    } else {
        echo "Success!<br />" . $_FILES['txt_file']['name'] . " has been uploaded to " . $ftp_server . $destination_file . "!<br /><br />";
    }

    ftp_close($conn_id); // Close the FTP Connection
}
?>

<html>
    <head>
        <script type="text/javascript">
            window.onload = function() {
                document.getElementById("progress").style.visibility = "hidden";
                document.getElementById("prog_text").style.visibility = "hidden";
            }
            
            function dispProgress() {
                document.getElementById("progress").style.visibility = "visible";
                document.getElementById("prog_text").style.visibility = "visible";
            }
            
        </script>
        
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            Please choose a file: <input name="txt_file" type="file" size="35" />
            <input type="submit" name="start_upload" value="Upload File" onClick="dispProgress()" />
        </form>
        
        <!-- Link to progress file: see http://www.ajaxload.info/ for animated gifs -->
        <img id="progress" src="http://www.your.site/images/progress.gif" />
        <p id="prog_text" style="display:inline;"> Upload Started!</p>
        
    </body>
<html>