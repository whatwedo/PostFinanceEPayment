# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [v1.1.0] - 2018-05-01
### Feature
- added custom zip code parameter with OWNERZIP (by @wanze)

## [v1.0.0] - 2017-05-31
### Fixed
- if getForm() is called twice the signature has been added twice

### Changed
- dropping support for PHP 5.3, PHP 5.4, PHP 5.5 and HHVM
- adding support for PHP 7.0, PHP 7.1

## [v0.1.0-ALPHA2] - 2015-10-17
### Added
- all Parameters for alias-usage
- allowing to pass an array of additional parameters to the `PostFinanceEPayment->createPayment` method
- added gateway URL for UTF-8 data (by [Ymox](https://github.com/Ymox) - thanks!)

## [v0.1.0-ALPHA1] - 2014-04-22
### Added
- handle payment request
- parse PostFinance response

[unreleased]: https://github.com/whatwedo/PostFinanceEPayment/compare/master...develop
[v1.0.0]: https://github.com/whatwedo/PostFinanceEPayment/compare/v0.1.0-ALPHA2...v1.0.0
[v0.1.0-ALPHA2]: https://github.com/whatwedo/PostFinanceEPayment/compare/v0.1.0-ALPHA1...v0.1.0-ALPHA2
[v0.1.0-ALPHA1]: https://github.com/whatwedo/PostFinanceEPayment/tree/v0.1.0-ALPHA1
