<?php
// app/Repositories/ClientRepository.php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{
    protected Client $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function all(int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)->get();
    }

    public function paginate(int $companyId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->where('company_id', $companyId)->paginate($perPage);
    }

    public function findById(int $id, int $companyId): ?Client
    {
        return $this->model->where('company_id', $companyId)->find($id);
    }

    public function create(array $data): Client
    {
        return DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });
    }

    public function update(int $id, array $data): Client
    {
        return DB::transaction(function () use ($id, $data) {
            $client = $this->model->findOrFail($id);
            $client->update($data);
            return $client->fresh();
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->model->findOrFail($id)->delete();
        });
    }

    public function search(int $companyId, string $term): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('company_name', 'like', "%{$term}%")
                    ->orWhere('gstin', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            })
            ->limit(10)
            ->get();
    }

    public function findByGSTIN(int $companyId, string $gstin): ?Client
    {
        return $this->model->where('company_id', $companyId)
            ->where('gstin', $gstin)
            ->first();
    }

    public function getActive(int $companyId): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->where('is_active', true)
            ->get();
    }

    public function getByState(int $companyId, string $stateCode): Collection
    {
        return $this->model->where('company_id', $companyId)
            ->where('state_code', $stateCode)
            ->get();
    }

    public function getFiltered(int $companyId, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->where('company_id', $companyId);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('company_name', 'like', "%{$filters['search']}%")
                    ->orWhere('gstin', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['client_type'])) {
            $query->where('client_type', $filters['client_type']);
        }

        if (!empty($filters['state_code'])) {
            $query->where('state_code', $filters['state_code']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        $perPage = $filters['per_page'] ?? 15;
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}