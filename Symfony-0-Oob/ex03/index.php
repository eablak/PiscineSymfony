<?php

include "TemplateEngine.php";

$elem = new Elem('html');
$head = new Elem('head');
$head->pushElement(new Elem('title', 'This is Title'));
$elem->pushElement($head);
$body = new Elem('body');
$body->pushElement(new Elem('div'));
$body->pushElement(new Elem('p', 'Lorem ipsum'));
$elem->pushElement($body);
$templateEngine = new TemplateEngine($elem);

$templateEngine->createFile("test.html");

?>