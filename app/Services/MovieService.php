<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class MovieService
{
    /**
     * @var ActorService
     */
    private $actorService;

    /**
     * @param ActorServis $actorService
     */
    public function __construct(ActorService $actorService)
    {
        $this->actorService = $actorService;
    }

    /**
     * @param  array $params
     * @return array
     */
    public function create(array $params): array
    {
        if ($actors = $params['actors'] ?? []) {
            unset($params['actors']);
        }

        $params['user_id'] = Auth::guard('api')->user()->id;
        $movie = Movie::create($params);

        foreach ($actors as $actorInfo) {
            $actor = $this->actorService->get($actorInfo);
            $movie->actors()->attach($actor);
        }

        return [
            'success' => true,
            'id' => $movie->id,
        ];
    }

    /**
     * @param  array $params
     * @return array
     */
    public function getAll(array $params): array
    {
        if ($actorName = $params['actor'] ?? false) {
            unset($params['actor']);
        }

        $movies = Movie::where($params)->with('actors');

        if ($actorName) {
            $movies->whereHas('actors', function($query) use ($actorName) {
                $query->where('name', '=', $actorName)
                    ->orWhere('surname', '=', $actorName);
            });
        }

        return [
            'success' => true,
            'movies' => $movies->get(),
        ];
    }

    /**
     * @param  int $id
     * @return array
     */
    public function getById(int $id): array
    {
        $movie = Movie::with('actors')->where('id', $id)->first();

        return [
            'success' => !is_null($movie),
            'movie' => $movie,
        ];
    }

    /**
     * @param  int $id
     * @return array
     */
    public function deleteById(int $id): array
    {
        $movie = Movie::find($id);

        $response = [
            'success' => !is_null($movie),
        ];

        if (!is_null($movie)) {
            if (Auth::guard('api')->user()->id !== $movie->user_id) {
                return [
                    'success' => false,
                    'message' => 'Access denied.',
                ];
            }

            $movie->delete();
        }

        return $response;
    }

    /**
     * @param  int $id
     * @param  array $params
     * @return array
     */
    public function update(int $id, array $params): array
    {
        $movie = Movie::find($id);

        $response = [
            'success' => !is_null($movie),
        ];

        if (!is_null($movie)) {
            if (Auth::guard('api')->user()->id !== $movie->user_id) {
                return [
                    'success' => false,
                    'message' => 'Access denied.',
                ];
            }

            $movie->update($params);
        }

        return $response;
    }
}
