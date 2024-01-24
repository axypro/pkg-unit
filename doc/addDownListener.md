# Down listeners

* `addDownListener(Closure): int`
* `removeDownListener(int): bool`

You can set a down listener inside a test or `setUp()` and it will be performed in `tearDown()`.
`addDownListener()` returns the listener ID (unique for one test) that can be used in `removeDownListener()`.
