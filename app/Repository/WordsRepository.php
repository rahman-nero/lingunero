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

    public function getWordsByLibraryId(int $libraryId): object
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
            ->newQuery()
            ->select($columns)
            ->where('library_id', $libraryId)
            ->orderBy('created_at')
            ->toBase()
            ->get();
    }

    public function get()
    {
        return $this->model()
            ->all();
    }

}
