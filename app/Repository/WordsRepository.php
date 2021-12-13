<?php


namespace App\Repository;


use App\Models\Words;

/**
 * @method Words model()
 */
final class WordsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Words::class;
    }

    public function get()
    {
        return $this->model()
            ->all();
    }

}
