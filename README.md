# Csabacenter Development Environment

## Requirements

* Docker `2.0.0.2 (30215)` or newer

In order to use the asset or database synchronisation described in the commands section,
please provide your public SSH key in order to authenticate properly on the remote servers.

Please note that this docker environment will use the ports `80`, `3306` and `8025` on your system, so make sure
that those ports are free to use.

## Setup

Add a new entry to your hosts file:

```
127.0.0.1 www.csabacenter.hu.test
```

Start the docker containers:

```
$ docker-compose up -d
```

If you use a passphrase on your SSH key, you first need to add your key to the ssh-agent manually:

```
$ docker-compose exec php /bin/bash
$ eval `ssh-agent`
$ ssh-add
```

Install TYPO3 CMS

```
$ docker-compose exec php /bin/bash
$ composer install
```

Fetch assets & database from staging server:

```
$ docker-compose exec php /bin/bash
$ bash bin/sync-assets.sh -s staging -t dev
$ bash bin/sync-db.sh -s staging -t dev
```

## Commands

```
# Use bash inside PHP container
$ docker-compose exec php /bin/bash

# Use TYPO3 Console
$ docker-compose exec php /bin/bash
$ ./vendor/bin/typo3cms list

# Flush TYPO3 CMS cache
$ docker-compose exec php /bin/bash
$ ./vendor/bin/typo3cms cache:flush

# Sync database from staging or production server
$ docker-compose exec php /bin/bash
$ bash bin/sync-db.sh -s staging|production -t dev

# Sync assets from staging or production server
$ docker-compose exec php /bin/bash
$ bash bin/sync-assets.sh -s staging|production -t dev

# View PHP error log
$ docker-compose logs -f php

# Shutdown Docker environment
$ docker-compose stop

# Apply changes to Docker environment
$ docker-compose build

# Completely remove Docker environment
$ docker-compose rm
```


## Setup XDebug

First you have to setup an an alias IP for Docker to connect to.
This has to be done after every reboot.

```
sudo ifconfig lo0 alias 10.254.254.254
```

As an alternative, you can put <https://gist.githubusercontent.com/manuelselbach/8a214ae012964b1d49d9fb019f5f5d7b/raw/469b06d8624ee851619906ec392233bd4c9a6c09/com.manuelselbach.docker_10254254254_alias.plist>
into `/Library/LaunchDaemons/`, which will be executed automatically on every boot.

Setup for PHPStorm:

Go to `Languages & Frameworks / PHP / Debug / DBGp Proxy` and set

```
IDE key: PHPSTORM
Host: 10.254.254.254
Port: 9000
```

Go to `Languages & Frameworks / PHP / Servers`

Click `+` and set:

```
Name: www.csabacenter.hu.test
Host: www.csabacenter.hu.test
Port: 80
Debugger: Xdebug

Add a path mapping
/path/to/csabacenter-typo3/www/html -> /var/www/html
```

Install [Xdebug helper for Chrome](https://chrome.google.com/webstore/detail/xdebug-helper/eadndfjplgieldjbigjakmdgkmoaaaoc)
and enable debug on <http://www.csabacenter.hu.test>.

Now you can start listening for "PHP Debug Connections" in PHPStorm.

## Access mails

Mails will be send to mailhog service available via <http://www.csabacenter.hu.test:8025/>

##Apache
The files created by the Apache must belong to the current SSH user so that the deployer does not get stuck while setting the rights. The AssignUserId directive can be used for this.

``
