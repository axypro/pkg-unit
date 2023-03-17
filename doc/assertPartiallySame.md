# assertPartiallySame()

Arguments:

* `array|object $expected`
* `mixed $actual`
* `string $message = ''`
* `bool $strict = true`
* `bool $allowNull = false`

Checks if `$actual` contains values as described in `$expected`.
Unlike `assertSame()` and `assertEquals()` `$actual` can contain other fields which are not important in this test.

```php
$expected = [
    'first_name' => 'John',
    'last_name' => 'Tester',
];

$actual = [
    'first_name' => 'John',
    'last_name' => 'Tester',
    'email' => 'john@example.com',
    'age' => 25,
];

$this->assertPartiallySame($expected, $actual); // we check only important fields for us
```

* `$actual` and `$expected` are compared as arrays. These can be objects but will be cast to arrays.
* If `$actual` is not array or object it leads to fail.
* If arrays are associative order of keys is not important.
* `$strict = false` - allows compare `int` with `string` and `int` with `bool`.
* `$allowNumm = true` - if a key is missing in `$actual` it is equivalent to `NULL`.
