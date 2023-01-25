<?php
declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->loadEnv(__DIR__.'/config/.env');

$configDirectories = [__DIR__.'/config'];

$fileLocator = new FileLocator($configDirectories);

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, $fileLocator);
$loader->load('system_settings.yaml');
$container->compile(true);
dump($container->getParameterBag()->all());
