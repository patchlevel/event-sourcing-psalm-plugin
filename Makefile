help:                                                                           ## shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

vendor: composer.lock
	composer install

.PHONY: phpcs-check
phpcs-check: vendor                                                             ## run phpcs
	vendor/bin/phpcs

.PHONY: phpcs-fix
phpcs-fix: vendor                                                               ## run phpcs fixer
	vendor/bin/phpcbf

.PHONY: cs
cs: vendor                                                                      ## run phpcs fixer
	vendor/bin/phpcbf || true
	vendor/bin/phpcs

.PHONY: psalm
psalm: vendor                                                                   ## run psalm static code analyser
	vendor/bin/psalm

.PHONY: psalm-baseline
psalm-baseline: vendor                                                          ## run psalm static code analyser
	vendor/bin/psalm --update-baseline --set-baseline=baseline.xml

.PHONY: static
static: psalm phpcs-check                                               ## run static analyser

test: psalm                                                                   ## run tests
