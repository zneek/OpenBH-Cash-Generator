<?php
/******** Syndk8's OpenBH *********
 *
 * This program is free software
 * licensed under the GPLv2 license.
 * You may redistribute it and/or
 * modify it under the terms of
 * the GPLv2 license (see license.txt)
 *
 * Warning:
 * OpenBH is for educational use
 * Use OpenBH at your own risk !
 *
 * Credits:
 * https://www.syndk8.com/openbh/people.html
 *
 ********************************/


/**
 *   manage/install.php
 *   create missing folders tries to chmod your stuff etc to be ready for work ..
 *
 *   @author Neek
 *   @todo create all missing crap
 */
?>
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