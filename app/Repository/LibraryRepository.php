<?php


namespace App\Repository;


use App\Models\Library;
use App\Models\Words;

/**
 * @method Words model()
 */
final class LibraryRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Library::class;
    }

    public function get()
    {
        return $this->model()
            ->all();
    }

}
