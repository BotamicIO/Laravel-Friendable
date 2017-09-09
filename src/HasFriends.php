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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFriends
{
    /**
     * @return mixed
     */
    public function friends(): MorphMany
    {
        return $this->morphMany(Friend::class, 'sender');
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function befriend(Model $recipient): bool
    {
        if ($this->isFriendsWith($recipient)) {
            return true;
        }

        $friendship = (new Friend())->forceFill([
            'recipient_id'   => $recipient->id,
            'recipient_type' => get_class($recipient),
            'status'         => Status::PENDING,
        ]);

        return (bool) $this->friends()->save($friendship);
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function unfriend(Model $recipient): bool
    {
        if (!$this->isFriendsWith($recipient)) {
            return false;
        }

        return (bool) $this->findFriendship($recipient)->delete();
    }

    /**
     * @param Model $recipient
     * @param null  $status
     *
     * @return mixed
     */
    public function isFriendsWith(Model $recipient, $status = null): bool
    {
        $exists = $this->findFriendship($recipient);

        if (!empty($status)) {
            $exists = $exists->where('status', $status);
        }

        return (bool) $exists->count();
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function acceptFriendRequest(Model $recipient): bool
    {
        if (!$this->isFriendsWith($recipient)) {
            return false;
        }

        return (bool) $this->findFriendship($recipient)->update([
            'status' => Status::ACCEPTED,
        ]);
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function denyFriendRequest(Model $recipient): bool
    {
        if (!$this->isFriendsWith($recipient)) {
            return false;
        }

        return (bool) $this->findFriendship($recipient)->update([
            'status' => Status::DENIED,
        ]);
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function blockFriendRequest(Model $recipient): bool
    {
        if (!$this->isFriendsWith($recipient)) {
            return false;
        }

        return (bool) $this->findFriendship($recipient)->update([
            'status' => Status::BLOCKED,
        ]);
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function unblockFriendRequest(Model $recipient): bool
    {
        if (!$this->isFriendsWith($recipient)) {
            return false;
        }

        return (bool) $this->findFriendship($recipient)->update([
            'status' => Status::PENDING,
        ]);
    }

    /**
     * @param $recipient
     *
     * @return mixed
     */
    public function getFriendship($recipient): Friend
    {
        return $this->findFriendship($recipient)->first();
    }

    /**
     * @param null $limit
     * @param null $offset
     *
     * @return array
     */
    public function getAllFriendships($limit = null, $offset = null): array
    {
        return $this->findFriendshipsByStatus(null, $limit, $offset);
    }

    /**
     * @param null $limit
     * @param int  $offset
     *
     * @return array
     */
    public function getPendingFriendships($limit = null, $offset = 0): array
    {
        return $this->findFriendshipsByStatus(Status::PENDING, $limit, $offset);
    }

    /**
     * @param null $limit
     * @param int  $offset
     *
     * @return array
     */
    public function getAcceptedFriendships($limit = null, $offset = 0): array
    {
        return $this->findFriendshipsByStatus(Status::ACCEPTED, $limit, $offset);
    }

    /**
     * @param null $limit
     * @param int  $offset
     *
     * @return array
     */
    public function getDeniedFriendships($limit = null, $offset = 0): array
    {
        return $this->findFriendshipsByStatus(Status::DENIED, $limit, $offset);
    }

    /**
     * @param null $limit
     * @param int  $offset
     *
     * @return array
     */
    public function getBlockedFriendships($limit = null, $offset = 0): array
    {
        return $this->findFriendshipsByStatus(Status::BLOCKED, $limit, $offset);
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function hasBlocked(Model $recipient): bool
    {
        return $this->getFriendship($recipient)->status === Status::BLOCKED;
    }

    /**
     * @param Model $recipient
     *
     * @return bool
     */
    public function isBlockedBy(Model $recipient): bool
    {
        $friendship = Friend::where(function ($query) use ($recipient) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            $query->where('recipient_id', $recipient->id);
            $query->where('recipient_type', get_class($recipient));
        })->first();

        return $friendship ? ($friendship->status === Status::BLOCKED) : false;
    }

    /**
     * @return mixed
     */
    public function getFriendRequests(): Collection
    {
        return Friend::where(function ($query) {
            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));
            $query->where('status', Status::PENDING);
        })->get();
    }

    /**
     * @param Model $recipient
     *
     * @return mixed
     */
    private function findFriendship(Model $recipient): Builder
    {
        return Friend::where(function ($query) use ($recipient) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            $query->where('recipient_id', $recipient->id);
            $query->where('recipient_type', get_class($recipient));
        })->orWhere(function ($query) use ($recipient) {
            $query->where('sender_id', $recipient->id);
            $query->where('sender_type', get_class($recipient));

            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));
        });
    }

    /**
     * @param $status
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    private function findFriendshipsByStatus($status, $limit, $offset): array
    {
        $friendships = [];

        $query = Friend::where(function ($query) use ($status) {
            $query->where('sender_id', $this->id);
            $query->where('sender_type', get_class($this));

            if (!empty($status)) {
                $query->where('status', $status);
            }
        })->orWhere(function ($query) use ($status) {
            $query->where('recipient_id', $this->id);
            $query->where('recipient_type', get_class($this));

            if (!empty($status)) {
                $query->where('status', $status);
            }
        });

        if (!empty($limit)) {
            $query->take($limit);
        }

        if (!empty($offset)) {
            $query->skip($offset);
        }

        foreach ($query->get() as $friendship) {
            $friendships[] = $this->getFriendship($this->find(
                ($friendship->sender_id == $this->id) ? $friendship->recipient_id : $friendship->sender_id
            ));
        }

        return $friendships;
    }
}
