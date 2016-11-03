<?php
// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

// Constant for api version
define('API_V2', TRUE);

/**
 * Let bootstrap create Dependency Injection container.
 * @var \Nette\DI\Container $container
 */
$container = require dirname(__DIR__) . '/bootstrap.php';

/**
 * Run application.
 * @var \Nette\Application\Application $application
 */
$application = $container->getByType('Nette\Application\Application');
$application->run();
