# CLDR CLI

[![Release](https://img.shields.io/packagist/v/icanboogie/cldr-cli.svg)](https://packagist.org/packages/icanboogie/cldr-cli)

A CLI for [ICanBoogie/CLDR][].


#### Usage

Use the `warm-up` command to warm up the CLDR cache. This is especially useful if you want to
restrict the usage of the CLDR to the warmed-up data. Use the `--dir` option to specify the
directory you use for the CLDR cache, defaults to `.cldr-cache`.

```shell
./vendor/bin/cldr warm-up us fr de
```



#### Installation

```shell
composer require icanboogie/cldr-cli
```



----------



## Continuous Integration

The project is continuously tested by [GitHub actions](https://github.com/ICanBoogie/CLDR-CLI/actions).

[![Tests](https://github.com/ICanBoogie/CLDR-CLI/actions/workflows/test.yml/badge.svg?branch=6.0)](https://github.com/ICanBoogie/CLDR-CLI/actions?query=workflow%3Atest)
[![Static Analysis](https://github.com/ICanBoogie/CLDR-CLI/actions/workflows/static-analysis.yml/badge.svg?branch=6.0)](https://github.com/ICanBoogie/CLDR-CLI/actions?query=workflow%3Astatic-analysis)
[![Code Style](https://github.com/ICanBoogie/CLDR-CLI/actions/workflows/code-style.yml/badge.svg?branch=6.0)](https://github.com/ICanBoogie/CLDR-CLI/actions?query=workflow%3Acode-style)



## Code of Conduct

This project adheres to a [Contributor Code of Conduct](CODE_OF_CONDUCT.md). By participating in
this project and its community, you're expected to uphold this code.



## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for details.



## License

**icanboogie/cldr-cli** is released under the [MIT License](LICENSE).



[ICanBoogie/CLDR]: https://github.com/ICanBoogie/CLDR/
