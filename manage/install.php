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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="en" />
<meta name="robots" content="all,follow" />
<meta name="Description" content="..." />
<meta name="Keywords" content="..." />
<link type="text/css" rel="stylesheet" href="http://www.openbh.com/styling/reset.css" />
<link type="text/css" rel="stylesheet" href="http://www.openbh.com/styling/main.css" />
<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="http://www.openbh.com/styling/main-ie6.css" /><![endif]-->
<script src="http://www.openbh.com/js/debug.js" type="text/javascript" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="http://www.openbh.com/styling/style.css" />
<script src="http://www.openbh.com/js/jquery-1.3.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="http://www.openbh.com/js/loopedslider.js" type="text/javascript" charset="utf-8"></script>
<title>OpenBH Installer</title>
<style type="text/css">
.style1 {
 color: #0000FF
}
.style2 {
 color: #0000FF;
 font-weight: bold;
}
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
 td { vertical-align: top; }
.style4 {color: #990000}
        </style>
    </head>
<body>
<div id="main">
  <!-- Header -->
  <div id="header" class="box">
    <hr class="noscreen" />
    <!-- Navigation -->
    <ul id="nav">
      <li><a href="http://www.openbh.com/"><span>Home</span></a></li>
      <!-- Active (.active) -->
      <li><a href="http://www.openbh.com/project.html"><span>Project</span></a></li>
      <li><a href="http://www.openbh.com/people.html"><span>The People</span></a></li>
      <li><a href="http://www.openbh.com/involved.html"><span>Get Involved</span></a></li>
      <li><a href="http://www.openbh.com/download.html"><span>FREE Download</span></a></li>
      <li><a href="http://www.openbh.com/news.html"><span>News</span></a></li>
      <li><a href="http://forum.openbh.com/"><span>Forum</span></a></li>
      <li><a href="http://www.openbh.com/licence.html"><span>Licence</span></a></li>
      <li><a href="http://www.openbh.com/credits.html"><span>Credits</span></a></li>
    </ul>
  </div>
  <!-- /header -->
  <hr class="noscreen" />
  <!-- Title + Subcategories -->
  <div class="box-01">
    <!-- Slogan (design/hx-slogan.gif) -->
    <div id="slogan">
      <h1><span></span><br />
      </h1>
    </div>
    <hr class="noscreen" />
    <!-- Ribbon (design/box-01-ribbon.gif) -->
    <div id="ribbon">
      <h4 class="hidden">Price: $0,00</h4>
    </div>
    <!-- Button ("Purchase") -->
    <p id="button"><a href="http://www.openbh.com/download.html"><img src="http://www.openbh.com/design/box-01-button.gif" alt="FREE Download" /></a></p>
    <hr class="noscreen" />
    <!-- News -->
    <div id="news"><strong>What´s New:</strong> <a href="http://www.openbh.com/download.html">Version 1.0 Alpha is available for FREE download </a></div>
    <!-- Twitter -->
    <div id="twitter"><a href="http://twitter.com/openbh">Follow us on Twitter</a></div>
  </div>
  <!-- /title -->
  <!-- Breadcrumbs -->
  <!-- Columns -->
  <div class="cols-top"></div>
  <div class="cols box">
    <!-- Content -->
    <div class="content">
      <!-- Perex -->
      <div class="perex">
        <p>OpenBH Web Site Quick Installer</p>
      </div>

<?php      
if($_POST['inst']=='setup') {
     /* install here */
     if(is_numeric($_POST['i8f_id'])) {
        file_put_contents('../templates/i8f_Acai/site.html', str_replace('value="34"',"value=\"{$_POST['i8f_id']}\"",file_get_contents('../templates/i8f_Acai/site.html')));
     }
     $cnf = file_get_contents('../config/config.php');
     $cnf = preg_replace("/\['template'\] = '.+?';/",sprintf("['template'] = '%s';",$_POST['template']),$cnf);
     $cnf = preg_replace("/\['domain'\] = '.+?';/",sprintf("['domain'] = '%s';",$_POST['url']),$cnf);
     $cc = explode(':',file_get_contents('https://www.syndk8.com/indiansuperhorse/cc/'));
     $cnf = preg_replace("/\['cc'\] = '.+?';/",sprintf("['cc'] = '%s';",$cc[0]),$cnf);
     $cnf = preg_replace("/\['cn'\] = '.+?';/",sprintf("['cn'] = '%s';",$cc[1]),$cnf);
     file_put_contents('../config/config.php', $cnf);
     file_put_contents('../config/kw/open.txt', $_POST['kwlist']);
     $urlencoded = urlencode($_POST['url']);
     echo "
      <h1>Installed...</h1>
        <iframe width=1px height=1px border=0 src='http://pingomatic.com/ping/?title=blogname&blogurl={$urlencoded}&rssurl=http%3A%2F%2F&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_syndic8=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_blogstreet=on&chk_moreover=on&chk_weblogalot=on&chk_icerocket=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_postrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on'></iframe>
        <h2><a href='../'>See My New Site</a></h2>
      ";
    touch('../data/logs/installed');
    exit;
}
?>
      
       <p><strong>Hello this is Earl Grey from Syndk8.com here.</strong><br />
       </p>
       <p>First let me say thanks for downloading and starting to install OpenBH on your website.<br />
         You have got this far so you are doing well. Only about 30 seconds away from having a live website.</p>
       <p>I have done everything i can do to try and make it as simple as possible to install your sites and get running.<br />
       If you use the Acia Berry template your mind will be blown on the quality of the template and how this simple system works.<br />
       </p>
       <p>If you havent seen the OpenBH Quick Start Document yet please download it <a href="http://openbh.com/OpenBH-Quick-Start-Guide-pdf-V1.pdf" class="style1"><strong>here</strong></a>.</p>
       <p>There are reams  of installation and implementation documents but i have tried my very best to make them simple to understand so even someone  new to making money online can get started.</p>
       <p>There is also a forum for OpenBH which is always there to support you if you need but more importantly so you can contribute any changes to templates you make or any additions to the code.</p>
       <p>I have kept you reading for long enough so its time to get your site up and running.</p>
       <p>Step 1. Fill in everything below.<br />
         Step 2. Press OK and wait a few seconds. It should then show a success page.<br />
         Step 3. Check out your new site and go to yourinstalledsite.com/manage/ to view your stats control panel.<br />
         Your pages will load slowly the first time you view them. This is a feature explained in the Quick Start Guide.<br />
         .<br />
       </p>
<?php
/**
 * OpenBH Basic Installer
 */


 if(!checkPermissions(0755)) {
 /* permissions and files ok */
    if(file_exists('../data/logs/installed')) {
        err("Already Installed - if you want to reinstall please remove the file 'installed' inside the folder 'data/logs/'");
    exit;
 } 
 

    $preselect = 'template2';
    foreach (glob("../templates/*",GLOB_ONLYDIR) as $templatefolder) {
        $tmphtml = file_get_contents($templatefolder."/site.html");
        preg_match('/@description:(.+)/',$tmphtml,$desc);
        preg_match('/@author:(.+)/',$tmphtml,$author);
        $name = str_replace("../templates/","",$templatefolder);
        $select = '';
        if($name == $preselect) {
            $select = ' checked';
        }
        $tmplselect = sprintf("%s<input type='radio' name='template' value='%s' %s /> <strong>%s</strong> by %s: %s<br />",$tmplselect,$name,$select,$name,$author[1],$desc[1]);
    }

    $initkwarr = file('../config/kw/open.txt');
    shuffle($initkwarr);
    $len = count($initkwarr);
    $initkws = implode('',array_slice($initkwarr,0,rand(0,$len)));

    $autourl = str_replace('manage/','',curPageURL());

    $frm = <<<EOT
<form action='install.php' method='post'>
    <div class="content-box box">
        <p class="nomt"><strong>Your Website Url: (include http://)</strong><br />
            <input type='text' name='url' size="80" class="input" value='{$autourl}'/>
            <br />
            Remember you can use folders/ subdomains or normal domains.</p>
	    <p class="nomt"><em>See the <a href="http://www.openbh.com/OpenBH-Quick-Start-Guide.docx" target="_blank" class="style1">OpenBH.com Quick Start Guide</a> to learn how to choose better domains and increase your chances of success.</em></p>
	    <p class="nomt">&nbsp;</p>
            <p><strong>Keywords (CSV or Paste into /kw/open.txt)</strong> (We have pre-populated it for you with seo and webmaster related keywords)<br />
            <textarea name='kwlist' cols="99" rows="10" class="input" style="width:550px; height:160px;">$initkws</textarea>
            <br />
            You can use as many keywords as you wish but don't be stupid and put 500k in. 400 to 800 is nice.</p>
          </p>
          <p><br />
        </p>
        <p class="nomt"><strong>Template:</strong><br />
            $tmplselect
            <br />
          You can build your own template or to get setup fast with money earning sites with the already existing ones.<br />
          As the project develops and people start contributing there will be many more templates to come.<strong><br />
          <br />
          </strong><em>If you are a designer or work in a  company with marketing budgets and product with affiliate commissions please post in the <a href="https://forum.syndk8.com/" class="style1">OpenBH forum</a> and we can show you how you can contribute to this project to benefit the users and also get benefit for your company.</em><strong><br />
            <br />
            <br />            
          <p align="center"><strong>Just do one final check everything is done as it is described and hit the button below.</strong></p>
          <p class="nomb t-center">
            <input type="image" value='setup' name='inst' src="http://www.openbh.com/design/btn-ok.gif" alt="ok" />
          </p>
        </div>
        <!-- /content-box -->
        <input type="hidden" name="inst" value="setup" />
    </form>
EOT;

    echo $frm;
} else {
    echo "<p>Please fix these errors to continue by referencing the Quick Start Document..</p>";
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

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

?>
<p align="center"><a href="http://www.openbh.com/">OpenBH</a> is an OpenSource GPLv2 Project which is Proudly Presented by <a href="https://www.syndk8.com/">Syndk8.com</a><br />
      </p>
    </div>
    <div class="aside">
      <h2>Social Stuff</h2>
      <ul class="ul-news">
        <li><strong>Email</strong> <a href="https://www.syndk8.com/contact/000163-contact.html">openbh@syndk8.com</a></li>
        <li><strong>Twitter</strong> <a href="http://www.twitter.com/openbh">Join OpenBH On Twitter</a></li>
      </ul>
      <h2>Code Resources and Technical</h2>
      <p><a href="http://www.openbh.com/developer-documentation.html">Developer Documentation</a><br />
        <a href="http://www.openbh.com/installation-documentation.html">Installation Documentation</a><br />
        <a href="http://www.openbh.com/readme.html">ReadMe</a> (Bundled with the software)</p>
      <h2>Resources</h2>
      <p><a href="https://www.syndk8.com/">Make Money Online</a><br />
        <a href="http://syndk8.x.i8f.com/">Herbal Affiliate Network</a></p>
    </div>
    <!-- /aside -->
  </div>
  <!-- /cols -->
  <div class="cols-bottom"></div>
  <hr class="noscreen" />
  <!-- Footer Start -->
  <div id="footer" class="box">
    <p align="center"><a href="http://www.openbh.com/">Home</a> - <a href="http://www.openbh.com/project.html">Project</a> - <a href="http://www.openbh.com/people.html">The People</a> - <a href="http://www.openbh.com/involved.html">Get Involved</a> - <a href="http://www.openbh.com/download.html">Free Download</a> - <a href="http://www.openbh.com/news.html">News</a> - <a href="http://forum.openbh.com/">Forum</a> - <a href="http://www.openbh.com/licence.html">Licence</a> - <a href="http://www.openbh.com/credits.html">Credits</a> - <a href="http://www.openbh.com/privacy.html">Privacy Policy</a><br />
    </p>
  </div>
</div>
<!-- Footer End -->
</body>
</html>