<?php

include_once "Coffee.php";
include_once "Tea.php";
include_once "TemplateEngine.php";


$coffee = new Coffee();
$tea = new Tea();
// echo $coffee->getDescription();
// echo $coffee->getName();
$templateEngine = new TemplateEngine();
$templateEngine->createFile($coffee);
$templateEngine->createFile($tea);

?>