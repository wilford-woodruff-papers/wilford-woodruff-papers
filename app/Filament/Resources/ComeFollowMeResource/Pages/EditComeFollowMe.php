<?php

namespace App\Filament\Resources\ComeFollowMeResource\Pages;

use App\Filament\Resources\ComeFollowMeResource;
use App\Models\Scriptures\Chapter;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComeFollowMe extends EditRecord
{
    protected static string $resource = ComeFollowMeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $cfm = $this->getRecord();
        $cfm->chapters()->detach();

        $chapters = collect($data)
            ->filter(fn ($value, $key) => str_starts_with($key, 'book_'))
            ->filter(fn ($value, $key) => ! empty($value))
            ->map(fn ($value, $key) => [
                'book' => str($key)->after('book_')->explode('_')->first(),
                'chapter' => str($key)->after('book_')->explode('_')->last(),
            ]);
        foreach ($chapters as $chapter) {
            $bookChapters = Chapter::where('book_id', $chapter['book'])
                ->where('id', $chapter['chapter'])->get();
            $cfm->chapters()->syncWithoutDetaching($bookChapters);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
