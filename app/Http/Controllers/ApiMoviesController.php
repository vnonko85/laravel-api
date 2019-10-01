<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Http\Requests\ApiMovieCreateRequest;
use App\Http\Requests\ApiMovieSearchRequest;
use App\Http\Requests\ApiMovieUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiMoviesController extends Controller
{
    public function store(MovieService $movieService, ApiMovieCreateRequest $request): JsonResponse
    {
        if (!Auth::guard('api')->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.',
            ]);
        }

        return response()->json($movieService->create($request->validated()));
    }

    public function getAll(MovieService $movieService, ApiMovieSearchRequest $request): JsonResponse
    {
        return response()->json($movieService->getAll($request->validated()));
    }

    public function getById(MovieService $movieService, int $id): JsonResponse
    {
        return response()->json($movieService->getById($id));
    }

    public function deleteById(MovieService $movieService, int $id): JsonResponse
    {
        if (!Auth::guard('api')->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.',
            ]);
        }

        return response()->json($movieService->deleteById($id));
    }

    /**
     * @param  MovieService $movieService,
     * @param  ApiMovieUpdateRequest $request,
     * @param  int $id
     * @return JsonResponse
     */
    public function update(
        MovieService $movieService,
        ApiMovieUpdateRequest $request,
        int $id
    ): JsonResponse
    {
        if (!Auth::guard('api')->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.',
            ]);
        }

        return response()->json($movieService->update($id, $request->validated()));
    }
}
