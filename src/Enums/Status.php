<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Friendable.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Friendable\Enums;

class Status
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const DENIED = 2;
    const BLOCKED = 3;
}
