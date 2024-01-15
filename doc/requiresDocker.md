# requiresDocker()

* `$this->requiresDocker([$message])` marks a test must be run in the predefined docker environment (see `docker` directory).
  If the environment is wrong it leads to `markTestSkipped()`.
* `$this->isInDocker(): bool` checks if a test run in the docker

The environment is determined by the environment variable `AXY_PKG_ENVIRONMENT` (must contain the "docker" value).
It can be specified in `docker/docker-compose.yml`.
