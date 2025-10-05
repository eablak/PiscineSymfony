<?php

include ("TemplateEngine.php");

$templateEngine = new TemplateEngine();
$templateEngine->createFile("fileName.html", "book_description.html", ["apple", "banana", "cherry", "p4", "p5"]);


?>