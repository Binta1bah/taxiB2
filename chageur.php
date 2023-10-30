<?php

function chargeur($classe)
{
    require $classe . ".class.php";
}

spl_autoload_register("chargeur");
