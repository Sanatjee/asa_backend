<?php

namespace App\Services;

use App\Models\ProgramKB;
use App\Repositories\Interfaces\ProgramKBRepositoryInterface;


class ProgramKBService
{

    public function __construct(
        protected ProgramKBRepositoryInterface $programKBrepo
    ){}

    public function list($filters)
    {
        return $this->programKBrepo->paginate($filters);
    }

    public function create($data)
    {
        return $this->programKBrepo->create($data);
    }

    public function update( ProgramKB $kb, $data )
    {
        return $this->programKBrepo->update(
            $kb,
            $data
        );
    }

    public function delete( ProgramKB $kb )
    {
        return $this->programKBrepo->delete($kb);
    }
}