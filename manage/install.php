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


if(checkPermissions(0755)) {
    /* permissions and files ok */
    
}



function checkPermissions($mode) {
    $err = false;
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
            $err = true;
            continue;
        }
        if(is_writeable($filename)) {
            ok("OK $filename");
            continue;
        }
        if(@chmod($filename,$mode)) {
            ok("changed mode of $filename to $mode successfully");
        }
        err("Permission Problem $filename");
        $err = true;
    }

    foreach($folders as $folder) {
        if(!file_exists($folder)) {
            if(mkdir($folder,$mode)) {
                ok("Folder $folder created and mode set to $mode");
                continue;
            }
            err("could not create $folder");
            $err = true;
        }
        if(!is_writeable($folder)) {
            if(@chmod($folder,$mode)) {
                ok("changed mode of $folder to $mode successfully");
                continue;
            }
            err("$folder not writeable");
            $err = true;
        }
        ok("$folder looking good");
    }
    return $err;
}

function err($msg) {
    echo sprintf('<span class="err">%s</span><br/>',$msg);
}
function ok($msg) {
    echo sprintf('<span class="ok">%s</span><br/>',$msg);
}

?>
</html>