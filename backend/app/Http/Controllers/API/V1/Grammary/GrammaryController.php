<?php

namespace App\Http\Controllers\API\V1\Grammary;

use App\Helpers\ApiResponse;
use App\Http\Controllers\API\V1\Grammary\Responses\GrammaryResource;
use App\Http\Controllers\Controller;
use App\Repository\GrammaryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * API контроллер тем по грамматике
 */
class GrammaryController extends Controller
{
    public function __construct(
        private readonly GrammaryRepository $repository
    ) {
    }

    /**
     * Список тем по грамматике (с пагинацией).
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = (int) $request->input('per_page', 10);
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 10;

        $paginator = $this->repository->getAllWithPaginate($perPage);

        return GrammaryResource::collection($paginator);
    }

    /**
     * Одна тема по грамматике по ID.
     *
     * @param int $id Идентификатор темы
     * @return GrammaryResource|JsonResponse
     */
    public function show(int $id): GrammaryResource|JsonResponse
    {
        $grammary = $this->repository->getById($id);

        if ($grammary === null) {
            return ApiResponse::notFound('Grammar topic not found');
        }

        return new GrammaryResource($grammary);
    }
}
