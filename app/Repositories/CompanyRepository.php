<?php

namespace App\Repositories;

use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;

final class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public function __construct(Company $company)
    {
        parent::__construct($company);
    }
}
