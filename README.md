# Laravel Friendable

[![Build Status](https://img.shields.io/travis/artisanry/Friendable/master.svg?style=flat-square)](https://travis-ci.org/artisanry/Friendable)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/artisanry/friendable.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/artisanry/Friendable.svg?style=flat-square)](https://github.com/artisanry/Friendable/releases)
[![License](https://img.shields.io/packagist/l/artisanry/Friendable.svg?style=flat-square)](https://packagist.org/packages/artisanry/Friendable)

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require artisanry/friendable
```

To get started, you'll need to publish the vendor assets and migrate:

```
php artisan vendor:publish --provider="Artisanry\Friendable\FriendableServiceProvider" && php artisan migrate
```

## Usage

## Setup a Model
``` php
<?php

namespace App;

use Artisanry\Friendable\HasFriends;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFriends;
}
```

## Examples

#### Send a Friend-Request to a Model
``` php
$user->befriend($userToBeFriendsWith);
```

#### Unfriend a Model
``` php
$user->unfriend($userToBeFriendsWith);
```

#### Deny a Friend-Request from a Model
``` php
$user->denyFriendRequest($userToBeFriendsWith);
```

#### Accept a Friend-Request from a Model
``` php
$user->acceptFriendRequest($userToBeFriendsWith);
```

#### Block a Model
``` php
$user->blockFriendRequest($userToBeFriendsWith);
```

#### Unblock a Model
``` php
$user->unblockFriendRequest($userToBeFriendsWith);
```

#### Check if the Model has blocked another Model
``` php
$user->hasBlocked($userToBeFriendsWith);
```

#### Check if one Model is blocked by another Model
``` php
$user->isBlockedBy($userToBeFriendsWith);
```

#### Check if a Friendship exists between two models
``` php
$user->isFriendsWith($userToBeFriendsWith);
```

#### Get a single friendship
``` php
$user->getFriendship($userToBeFriendsWith);
```

#### Get a list of all Friendships
``` php
$user->getAllFriendships();
```

#### Get a list of pending Friendships
``` php
$user->getPendingFriendships();
```

#### Get a list of accepted Friendships
``` php
$user->getAcceptedFriendships();
```

#### Get a list of denied Friendships
``` php
$user->getDeniedFriendships();
```

#### Get a list of blocked Friendships
``` php
$user->getBlockedFriendships();
```

#### Get a list of pending Friend-Requests
``` php
$user->getFriendRequests();
```

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@basecode.sh. All security vulnerabilities will be promptly addressed.

## Credits

This project exists thanks to all the people who [contribute](../../contributors).

## License

Mozilla Public License Version 2.0 ([MPL-2.0](./LICENSE)).
