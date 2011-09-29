<?php

define("WEB",       dirname(__FILE__));
define("ROOT",      dirname(WEB));
define("DS",        DIRECTORY_SEPARATOR);
define("CONF",      WEB.DS."conf");
define("CONTROLLER",ROOT.DS."controller");
define("CORE",      ROOT.DS."coeur");
define("MODEL",     ROOT.DS."model");
define("VUES",      ROOT.DS."vues");
define("CSS",       WEB.DS."css");
define("IMGS",      WEB.DS."imgs");
define("JS",        WEB.DS."js");
define("UPLOADS",   WEB.DS."uploads");

define("VUE_SYS",   VUES.DS."system");

define('PAGE_404',  VUE_SYS. "404.php");

define("LAYOUT_HEADER",     VUE_SYS . DS . "header.php");
define("LAYOUT_FOOTER",     VUE_SYS . DS . "footer.php");
define("LAYOUT_MENU",       VUE_SYS . DS . "menu.php");

require CORE . DS . 'includes.php';


?>