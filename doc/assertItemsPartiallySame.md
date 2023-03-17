# assertItemsPartiallySame()

Arguments:

* `array|object $expected`
* `mixed $actual`
* `string $message = ''`
* `bool $strict = true`
* `bool $allowNull = false`

```php
$expected = [
    ['id' => 1, 'name' => 'One'],
    ['id' => 2, 'name' => 'Two'],
];
$actual = [
    ['id' => 1, 'name' => 'One', 'additional_field' => 'value'],
    ['id' => 2, 'name' => 'Two', 'additional_field' => 'value'],
];

$this->assertItemsPartiallySame($expcted, $actual);
```

Compares two lists (or dictionaries) of structures.
Items of the `$actual` can contains fields that are not specified in `$expected` and will be ignored.

If `$expected` or `$actual` is object it will be cast to array.
If `$actual` is not array or object it leads to fail.

Only items of arrays are compared partially.
At the top level list of keys must be equal.
Order of keys is not important.

Two elements with the same keys (or indexes) are compared:

* If they are both arrays or objects use [assertPartiallySame](assertPartiallySame.md) algorithm.
* Otherwise, used the standard comparison.
* Arguments `$strict` and `$allowNull` affect both items and top level comparison.

