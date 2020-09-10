#!/bin/bash

cd ~ && env -i TYPO3_CONTEXT=$TYPO3_CONTEXT php -f $PWD/html/lowell/current/vendor/bin/typo3cms scheduler:run
