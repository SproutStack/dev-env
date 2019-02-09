#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$version = json_decode(file_get_contents(__DIR__ . '/composer.json'))->version ?: 'dev-master';

$application = new Application('SproutStack', $version);
$application->add(new App\Command\Example());
$application->run();
