## 0.1.4 (24.01.2024)

* Some dev improvements
* `addDownListener()`

## 0.1.3 (15.01.2024)

* Up phpunit to 10.5
* `requiresDocker()` marks a test must be run in the predefined docker environment

## 0.1.2 (14.10.2023)

* Convert warnings etc. into exceptions bypassing phpunit

## 0.1.1 (18.03.2023)

* `->tmpDir()->getPath()`: clear argument (the target path must not exist)

## 0.1.0 (18.03.2023)

* `BaseAxyTestCase`
    * `assertPartiallySame()`
    * `assertItemsPartiallySame()`
* `TestBootstrap`
* `TestTmpDir`
