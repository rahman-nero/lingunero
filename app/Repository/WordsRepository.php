<?php


namespace App\Repository;


use App\Models\Words;
use Illuminate\Support\Collection;

/**
 * @method Words model()
 */
final class WordsRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return Words::class;
    }

    public function getWordsByLibraryId(int $libraryId): Collection
    {
        $columns = ['id', 'word', 'translation', 'description'];

        return $this->model()
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
