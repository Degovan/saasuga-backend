<?php

namespace App\Repositories;

use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;

class UrlRepository
{
    public static function store(User $user, array $data): Url
    {
        $data['expiration'] = Carbon::now()->addMonth(3);

        return $user->urls()->create($data);
    }

    public static function update(Url $url, array $data)
    {
        return $url->update($data);
    }
}
