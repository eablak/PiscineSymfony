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
// $p->pushElement($sub_p);
$div->pushElement($p);
$body->pushElement($div);
$body->pushElement(new Elem('p', 'Lorem ipsum'));
$p2 = new Elem('p', 'This is some text in a paragraph.');
$body->pushElement(new Elem('img', null, ['width' => '100', 'height'=>'100']));
$body->pushElement(new Elem('br'));
$body->pushElement($p2);


$table = new Elem('table');
$tr = new Elem('tr');

$td = new Elem('td','Alfreds Futterkiste');
$td2 = new Elem('td','Maria Anders');
$td3 = new Elem('td','Germany');
$tr->pushElement($td);
$tr->pushElement($td2);
$tr->pushElement($td3);

$second_tr = new Elem('tr');
$th = new Elem('th','Centro comercial Moctezuma');
$th2 = new Elem('th','Francisco Chang');
$th3 = new Elem('th','Mexico');
$second_tr->pushElement($th);
$second_tr->pushElement($th2);
$second_tr->pushElement($th3);


$table->pushElement($tr);
$table->pushElement($second_tr);
$body->pushElement($table);


$ul = new Elem('ul');
$li = new Elem('li','Coffee');
$li2 = new Elem('li','Tea');
$li3 = new Elem('li','Milk');

$ul->pushElement($li);
$ul->pushElement($li2);
$ul->pushElement($li3);

$ol = new Elem('ol');
$li = new Elem('li','Red');
$li2 = new Elem('li','Green');
$li3 = new Elem('li','Blue');

$ol->pushElement($li);
$ol->pushElement($li2);
$ol->pushElement($li3);

$body->pushElement($ul);
$body->pushElement($ol);

$elem->pushElement($body);

// echo $elem->getHTML();

$templateEngine = new TemplateEngine($elem);
if ($elem->validPage())
    echo "Valid Page\n";
else
    echo "Not Valid Page\n";

?>