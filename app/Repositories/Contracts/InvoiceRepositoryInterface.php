<?php

namespace App\Repositories\Contracts;

use App\Models\Invoice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface
{
    public function getByCompany(int $companyId, array $filters = []): LengthAwarePaginator;
    public function findById(int $id, int $companyId): ?Invoice;
    public function findByNumber(string $invoiceNumber, int $companyId): ?Invoice;
    public function create(array $data): Invoice;
    public function update(int $id, array $data): Invoice;
    public function delete(int $id): bool;
    public function getByStatus(int $companyId, string $status): Collection;
    public function getOverdue(int $companyId): Collection;
    public function getByClient(int $clientId, int $companyId): Collection;
    public function getByDateRange(int $companyId, string $startDate, string $endDate): Collection;
    public function getTotalByStatus(int $companyId, string $status): float;
    public function getMonthlySummary(int $companyId, int $month, int $year): array;
}
    