<?php

namespace App\Services;

use App\Models\Actor;

class ActorService
{
    /**
     * @param  string $name
     * @param  string $surname
     * @return Actor
     */
    public function get(array $actorInfo): Actor
    {
        if (!$actor = Actor::where($actorInfo)->first()) {
            $actor = Actor::create($actorInfo);
        }

        return $actor;
    }
}
