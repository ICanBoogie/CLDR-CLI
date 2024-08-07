<?php

namespace ICanBoogie\CLDR\CLI;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Console\Application;

final class App
{
    private const COMMANDS = [
        WarmUpCommand::class,
    ];

    public static function run(): void
    {
        /** @var ContainerCommandLoader $commandLoader */
        $commandLoader = self::container()
            ->get('console.command_loader');

        $app = new Application(name: 'cldr', version: '6.0.0');
        $app->setCommandLoader($commandLoader);
        $app->run();
    }

    private static function container(): ContainerInterface
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new AddConsoleCommandPass());

        foreach (self::COMMANDS as $command) {
            $container
                ->register($command)
                ->addTag('console.command')
                ->setAutowired(true);
        }

        $container->compile();

        return $container;
    }
}
