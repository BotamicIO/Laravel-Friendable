<?php

/*
 * This file is part of Laravel Friendable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BrianFaust\Friendable;

class Status
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const DENIED = 2;
    const BLOCKED = 3;
}
