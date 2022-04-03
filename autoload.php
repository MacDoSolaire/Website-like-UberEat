<?php
function autoloader($className)
{
    if (file_exists("src/$className.php")) {
        include("src/$className.php");
    }
}

spl_autoload_register("autoloader");