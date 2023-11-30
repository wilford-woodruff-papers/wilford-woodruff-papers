<?php

namespace App\Livewire\DataTable;

trait WithSorting
{
    public $sorts = [];

    public function sortBy($field)
    {
        if (! isset($this->sorts[$field])) {
            $this->resetPage();

            return $this->sorts[$field] = 'asc';
        }

        if ($this->sorts[$field] === 'asc') {
            $this->resetPage();

            return $this->sorts[$field] = 'desc';
        }
        $this->resetPage();
        unset($this->sorts[$field]);
    }

    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
