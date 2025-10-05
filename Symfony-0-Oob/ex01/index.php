<?php

include "Text.php";
include "TemplateEngine.php";

$text = new Text(["Lorem ipsum dolor sit amet consectetur adipiscing elit.", "Ex sapien vitae pellentesque sem placerat in id.", "Pretium tellus duis convallis tempus leo eu aenean."]);

$text->append("Urna tempor pulvinar vivamus fringilla lacus nec metus.");

$templateEngine = new TemplateEngine();
$templateEngine->createFile("output.html", $text->readData());



?>