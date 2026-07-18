<?php

namespace App\Repositories\Interfaces;

use App\Models\ProgramKB;

interface ProgramKBRepositoryInterface
{
    public function paginate(array $filters = []);

    public function create(array $data): ProgramKB;

    public function update( ProgramKB $kb, array $data ): ProgramKB;

    public function delete( ProgramKB $kb ): bool;

    public function search( string $keyword );
}