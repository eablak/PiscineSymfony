<?php

include "TemplateEngine.php";

$elem = new Elem('html');
$head = new Elem('head');
$head->pushElement(new Elem('title', 'This is Title'));
$elem->pushElement($head);
$body = new Elem('body');
$body->pushElement(new Elem('div'));
$body->pushElement(new Elem('p', 'Lorem ipsum'));
$p2 = new Elem('p', 'This is some text in a paragraph.');
$body->pushElement(new Elem('img', null, ['width' => '100', 'height'=>'100']));
$body->pushElement(new Elem('br'));
$body->pushElement($p2);
$elem->pushElement($body);
$templateEngine = new TemplateEngine($elem);

$templateEngine->createFile("test.html");

?>