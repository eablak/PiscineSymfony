<?php

include "TemplateEngine.php";

$elem = new Elem('html');
$head = new Elem('head');
$head->pushElement(new Elem('title', 'This is Title'));
$head->pushElement(new Elem('meta'));
$elem->pushElement($head);
$body = new Elem('body');
$div = new Elem('div');
$sub_p = new Elem('p', 'wrong p');
$p = new Elem('p', 'Text inside div');
$p->pushElement($sub_p);
$div->pushElement($p);
$body->pushElement($div);
$body->pushElement(new Elem('p', 'Lorem ipsum'));
$p2 = new Elem('p', 'This is some text in a paragraph.');
$body->pushElement(new Elem('img', null, ['width' => '100', 'height'=>'100']));
$body->pushElement(new Elem('br'));
$body->pushElement($p2);
$elem->pushElement($body);
$templateEngine = new TemplateEngine($elem);

$elem->validPage();

?>