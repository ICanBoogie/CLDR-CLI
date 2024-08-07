<?php

namespace ICanBoogie\CLDR\CLI;

use DirectoryIterator;
use ICanBoogie\CLDR\Cache\FileCache;
use ICanBoogie\CLDR\Core\LocaleId;
use ICanBoogie\CLDR\Provider\CachedProvider;
use ICanBoogie\CLDR\Provider\WebProvider;
use ICanBoogie\CLDR\Repository;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('warm-up', "Warm up the CLDR cache")]
final class WarmUpCommand extends Command
{
    protected function configure(): void
    {
        $this->addOption(
            name: 'cache-dir',
            shortcut: 'd',
            mode: InputOption::VALUE_OPTIONAL,
            description: "The directory of the CLDR cache",
            default: FileCache::RECOMMENDED_DIR,
        );

        $this->addOption(
            name: 'clear',
            mode: InputOption::VALUE_NONE,
            description: "Clear the cache directory before the warm up",
        );

        $this->addArgument(
            name: 'locales',
            mode: InputArgument::REQUIRED | InputArgument::IS_ARRAY
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $cacheDir = $input->getOption('cache-dir');
        assert(is_string($cacheDir));
        $this->assertCacheDir($cacheDir);

        $locales = $input->getArgument('locales');
        assert(is_array($locales));
        $this->assertLocales($locales);

        if ($input->getOption('clear')) {
            $this->clearCacheDir($cacheDir);
        }

        $provider = new CachedProvider(
            new WebProvider(),
            new FileCache($cacheDir)
        );

        $repository = new Repository($provider);
        $w = $output->writeln(...);

        $w("Data will be stored in '$cacheDir'");

        $repository->supplemental->warm_up($w);

        foreach ($locales as $locale) {
            $repository->locale_for($locale)->warm_up($w);
        }

        return self::SUCCESS;
    }

    private function assertCacheDir(string $cacheDir): void
    {
        if (!is_writable($cacheDir)) {
            throw new RuntimeException("The directory '$cacheDir' is not writable");
        }
    }

    /**
     * @param string[] $locales
     */
    private function assertLocales(array $locales): void
    {
        foreach ($locales as $locale) {
            LocaleId::of($locale);
        }
    }

    private function clearCacheDir(string $cacheDir): void
    {
        $di = new DirectoryIterator($cacheDir);

        foreach ($di as $file) {
            if (!$file->isFile()) {
                continue;
            }

            unlink($file->getPathname());
        }
    }
}
