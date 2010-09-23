<html>
    <head>
        <title>OpenBH Install</title>
        <style>
            .msg {
                border: 1px black dashed;
                padding: 10px;
                margin: 5px;
            }

            .err {
                color: red;
                font-weight: bold;
            }
        </style>
    </head>
<?php
/**
 * OpenBH Basic Installer
 */


/* permissions */
if(checkPermissions()==false) {
    echo "<div class='msg'>Please make sure these Folders are writeable by php (use your ftp client to modify permissions)!</div>";
    exit;
}








function checkPermissions() {
    $ok = true;
    $files = array( '../data/content/',
                    '../data/img/',
                    '../config/config.php',
                    '../config/open.txt'
    );
    foreach($files as $filename) {
        if(is_writeable($filename)!=true) {
            $ok = false;
            echo sprintf('<span class="err">%s</span> not writeable by php<br/>',str_replace('..','',$filename));
        }
    }
    return $ok;
}


?>
</html>