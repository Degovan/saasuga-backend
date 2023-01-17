<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UrlResource;
use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        $urls = Url::where('user_id', $request->user()->id)
            ->paginate();

        return $this->withPagination(
            $urls,
            UrlResource::class,
            'urls'
        );
    }

    public function store(Request $request)
    {
        $url = UrlRepository::store($request->user(), $request->all());

        return $this->success(
            UrlResource::make($url),
            'Success add new url',
            201
        );
    }

    public function show(Url $url)
    {
        return $this->success(
            UrlResource::make($url),
            'Success retrieving URL data'
        );
    }

    public function update(Request $request, Url $url)
    {
        UrlRepository::update($url, $request->all());

        return $this->success(
            null,
            'URL data updated',
            204
        );
    }

    public function destroy(Url $url)
    {
        $url->delete();

        return $this->success(
            null,
            'URL data deleted',
            204
        );
    }
}
