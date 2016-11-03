<?php

// Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;
$configurator->setTempDirectory(__DIR__ . '/runtime');

// Enable Nette Debugger for error visualisation & logging
$configurator->setDebugMode(DEBUG_MODE);
$configurator->enableDebugger(__DIR__ . '/runtime/log');

setlocale(LC_COLLATE, 'en_US.UTF-8');
mb_internal_encoding('UTF-8');

// \Tracy\Debugger::$maxDepth = 5;

$configurator->onCompile[] = function($configurator, $compiler) {
    $compiler->addExtension('dibiPayments', new \Dibi\Bridges\Nette\DibiExtension22());
    $compiler->addExtension('dbDemoAccount', new \Dibi\Bridges\Nette\DibiExtension22()); // nazev sekce bude dbDemoAccount
};

DibiNettePanel::$maxLength = 2500;

// Create Dependency Injection container from config.neon file
$configurator->addConfig(__DIR__ . '/config/config.neon', APP_ENV);
if (file_exists(__DIR__ . '/config/config.local.neon'))
{
    $configurator->addConfig(__DIR__ . '/config/config.local.neon', $configurator::NONE); // none section
}

$container = $configurator->createContainer();

// SECURE COOKIES on HTTPS
if($container->getService('httpRequest')->isSecured()) {

    $container->getService('httpResponse')->cookieSecure = TRUE;

    $container->getService('session')->setOptions(array('cookie_secure' => TRUE));

}

return $container;
