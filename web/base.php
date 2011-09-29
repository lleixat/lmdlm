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
define("LAYOUT",    VUES.DS."layout");

define('PAGE_404',  VUE_SYS. "404.php");

define("LAYOUT_HEADER",     LAYOUT . DS . "header.php");
define("LAYOUT_FOOTER",     LAYOUT . DS . "footer.php");
define("LAYOUT_MENU",       LAYOUT . DS . "menu.php");

require CORE . DS . 'includes.php';


?>