<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\ICanBoogie\CLDR;

use ICanBoogie\CLDR\Cache\FileCache;
use ICanBoogie\CLDR\Core\Locale;
use ICanBoogie\CLDR\Core\LocaleId;
use ICanBoogie\CLDR\Provider;
use ICanBoogie\CLDR\Provider\CachedProvider;
use ICanBoogie\CLDR\Provider\RestrictedProvider;
use ICanBoogie\CLDR\Repository;

require __DIR__ . '/../vendor/autoload.php';

const CACHE_DIR = __DIR__ . '/../' . FileCache::RECOMMENDED_DIR;

if (!file_exists(CACHE_DIR)) {
    mkdir(CACHE_DIR);
}

function create_provider(): Provider
{
    static $provider;

    return $provider ??= new CachedProvider(
        new RestrictedProvider(),
        new FileCache(CACHE_DIR),
    );
}

function get_repository(): Repository
{
    static $repository;

    return $repository ??= new Repository(create_provider());
}

function locale_for(string|LocaleId $id): Locale
{
    return get_repository()->locale_for($id);
}

date_default_timezone_set('Europe/Madrid');
