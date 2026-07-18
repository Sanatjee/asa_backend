<?php

namespace App\Repositories\Eloquent;

use App\Models\ProgramKB;
use App\Repositories\Interfaces\ProgramKBRepositoryInterface;

class ProgramKBRepository implements ProgramKBRepositoryInterface
{

    public function paginate(array $filters = [])
    {
        return ProgramKB::query()
            ->when(
                $filters['search'] ?? null,
                function($q,$search){

                    $q->where(
                        'title',
                        'like',
                        "%$search%"
                    )
                    ->orWhere(
                        'content',
                        'like',
                        "%$search%"
                    );
                }
            )
            ->latest()
            ->paginate(15);
    }


    public function create(array $data): ProgramKB
    {
        return ProgramKB::create($data);
    }


    public function update(
        ProgramKB $kb,
        array $data
    ): ProgramKB {

        $kb->update($data);

        return $kb;
    }


    public function delete(
        ProgramKB $kb
    ): bool {

        return $kb->delete();
    }


    public function search(string $keyword)
    {
        return ProgramKB::where(
            'is_active',
            true
        )
        ->where(function($q) use($keyword){

            $q->where(
                'title',
                'like',
                "%$keyword%"
            )
            ->orWhere(
                'content',
                'like',
                "%$keyword%"
            );

        })
        ->get();
    }

}