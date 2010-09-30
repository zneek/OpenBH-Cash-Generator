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
            .ok {
                color: green;
            }
        </style>
    </head>
<?php
/**
 * OpenBH Basic Installer
 */


/* permissions etc */

checkPermissions();



function checkPermissions() {
    $folders = array( '../data/content/',
                    '../data/img/',
                    '../data/logs/'
    );
    $files = array( '../config/config.php',
                    '../config/kw/open.txt'
    );

    foreach($files as $filename) {
        if(!file_exists($filename)) {
            err("missing $filename");
            continue;
        }
        if(is_writeable($filename)) {
            ok("OK $filename");
            continue;
        }
        if(@chmod($filename,0755)) {
            ok("changed mode of $filename to 0755 successfully");
        }
        err("Permission Problem $filename");
    }

    foreach($folders as $folder) {
        if(!file_exists($folder)) {
            if(mkdir($folder,0755)) {
                ok("Folder $folder created and mode set to 0755");
                continue;
            }
            err("could ont create $folder");
        }
        if(!is_writeable($folder)) {
            if(@chmod($folder,0755)) {
                ok("changed mode of $folder to 0755 successfully");
                continue;
            }
            err("$folder not writeable");
        }
        ok("$folder looking good");
    }
}

function err($msg) {
    echo sprintf('<span class="err">%s</span><br/>',$msg);
}
function ok($msg) {
    echo sprintf('<span class="ok">%s</span><br/>',$msg);
}

?>
</html>