<?php
require 'vendor/autoload.php';
$ref = new ReflectionClass('Xendit\Invoice\Invoice');
foreach($ref->getMethods() as $m) echo $m->getName() . PHP_EOL;
