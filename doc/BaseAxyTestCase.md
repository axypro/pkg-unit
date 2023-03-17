# BaseAxyTestCase

The base class of tests.
Extends PHPUnit TestCase class.
A particular package defines its base class (the parent of Test-classes):

```php
namespace axy\package\tests;

use axy\pkg\unit\BaseAxyTestCase;

abstract class BaseTestCase extends BaseAxyTestCase
{
}
```

If you override `setUp()` or `tearDown()` we need call parent methods (`parent::setUp()`...).

The class adds follow assert-methods:

* [assertPartiallySame](assertPartiallySame.md)
* [assertItemsPartiallySame](assertItemsPartiallySame.md)
