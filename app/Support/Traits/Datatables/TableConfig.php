<?php

namespace App\Support\Traits\Datatables;

use Livewire\Attributes\On;

trait TableConfig
{
//    use WithSorting;
    public int $index = 0;

    #[On('refreshDatatable')]
    public function bootWithSorting(): void
    {
        $this->render();
    }

}
