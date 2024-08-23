<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface EloquentRepositoryInterface
{
    public function first(
        array $columns = ['*'],
        array $conditions = [],
        array $relations = [],
        ?array $filters = []
    ): ?Model;

    public function all(
        array $columns = ['*'],
        array $conditions = [],
        array $relationCount = [],
        array $relations = [],
        ?array $filters = [],
        ?string $sorting = null,
        ?array $customSorting = [],
    ): Collection;

    public function model(): Model;

    public function createQuery(): Builder;

    public function paginate(
        array $columns = ['*'],
        array $conditions = [],
        array $relations = [],
        array $relationCount = [],
        ?string $sorting = null,
        ?int $perPage = 20,
        ?array $customConditions = [],
        ?array $customSorting = [],
        ?array $customRelations = [],
        ?array $filters = [],
        ?bool $random = false,
    ): LengthAwarePaginator;

    public function allTrashed(): Collection;

    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $customRelations = [],
        array $appends = []
    ): ?Model;

    public function findTrashedById(int $modelId): ?Model;

    public function findOnlyTrashedById(int $modelId): ?Model;

    public function create(array $payload): ?Model;

    public function update(Model|int $model, array $payload): ?Model;

    public function deleteById(int $modelId): bool;

    public function deleteByModel(Model $model): bool;

    public function restoreById(int $modelId): bool;

    public function permanentlyDeleteById(int $modelId): bool;

    public function count($columns = '*', array $conditions = []): int;
}
