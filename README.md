# Laravel Friendable

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/laravel-friendable
```

And then include the service provider within `app/config/app.php`.

``` php
'providers' => [
    BrianFaust\Friendable\ServiceProvider::class
];
```

To get started, you'll need to publish the vendor assets and migrate:

```
php artisan vendor:publish --provider="BrianFaust\Friendable\ServiceProvider" && php artisan migrate
```

## Usage

## Setup a Model
``` php
<?php

namespace App;

use BrianFaust\Friendable\Contracts\Friendable;
use BrianFaust\Friendable\Traits\Friendable as FriendableTrait;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Friendable
{
    use FriendableTrait;
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

## Security

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.de. All security vulnerabilities will be promptly addressed.

## License

The [The MIT License (MIT)](LICENSE). Please check the [LICENSE](LICENSE) file for more details.
