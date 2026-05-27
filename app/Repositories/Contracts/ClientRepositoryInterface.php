<?php
// app/Repositories/Contracts/ClientRepositoryInterface.php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Client;

interface ClientRepositoryInterface
{
    public function all(int $companyId): Collection;
    public function paginate(int $companyId, int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id, int $companyId): ?Client;
    public function create(array $data): Client;
    public function update(int $id, array $data): Client;
    public function delete(int $id): bool;
    public function search(int $companyId, string $term): Collection;
    public function findByGSTIN(int $companyId, string $gstin): ?Client;
    public function getActive(int $companyId): Collection;
    public function getByState(int $companyId, string $stateCode): Collection;
    public function getFiltered(int $companyId, array $filters = []): LengthAwarePaginator;
}