<?php

namespace Deployer;

require 'recipe/common.php';
require 'recipe/rsync.php';

inventory('hosts.yml');

set('shared_dirs', [
    '{{webroot}}/fileadmin',
    '{{webroot}}/typo3temp',
    'var'
]);

set('writable_dirs', [
    '{{webroot}}/fileadmin',
    '{{webroot}}/typo3temp',
    '{{webroot}}/typo3conf',
    'var'
]);

set('rsync_src', __DIR__);
set('rsync_dest','{{release_path}}');

set('rsync', array_merge(get('rsync'), [
    'exclude' => [
        '.git',
        'node_modules',
        'composer.json',
        'composer.lock',
        'deploy.php',
        'hosts.yml'
    ],
    'timeout' => 600,
    'flags' => 'rzl'
]));

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'setphp',
    'database:updateschema',
    'language:update',
    'cache:flush',
    'deploy:unlock',
    'cleanup',
    'success'
]);

task('setphp', function() {
    run('export PATH="/kunden/homepages/7/d734787902/htdocs/workaround:$PATH"');
});

task('cache:flush', function() {
    run('cd {{release_path}} && env -i TYPO3_CONTEXT={{typo3_context}} php -f vendor/bin/typo3cms cache:flush');
});

task('database:updateschema', function() {
    run('cd {{release_path}} && env -i TYPO3_CONTEXT={{typo3_context}} php -f vendor/bin/typo3cms database:updateschema');
});

task('language:update', function() {
    run('cd {{release_path}} && env -i TYPO3_CONTEXT={{typo3_context}} php -f vendor/bin/typo3cms language:update');
});
