<?php

namespace App\Support\Traits\Datatables;

trait TableConfiguration
{
//    use WithSorting;
    public int $index = 0;

    public function bootWithSorting(): void
    {
        $this->defaultSortColumn = 'id';
        $this->defaultSortDirection = 'desc';
    }

    public function initializeTableConfiguration(): void
    {
        $this->listeners = array_merge($this->listeners, [
            'refreshDatatable' => 'resetIndex',
        ]);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setBulkActionsEnabled();
        $this->setPerPageAccepted([50, 100, 200, 500]);

        $this->setHideBulkActionsWhenEmptyEnabled();
        $this->setFilterLayoutSlideDown();
        $this->setBulkActions([
            'deleteSelected' => 'Delete Selected',
        ]);

        $this->setTableWrapperAttributes([
            'class' => 'table align-middle table-row-dashed fs-6 gy-5',
        ]);

        $this->setTrAttributes(function ($row) {
            return [
                'class' => 'text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0',
            ];
        });

        $this->setThAttributes(function ($row) {
            return [
                'class' => 'ps-0',
            ];
        });

        $this->setTbodyAttributes([
            'class' => 'fw-bold text-gray-600',
        ]);
    }

    public function deleteSelected(): void
    {
        $this->dispatch('deleteAll', $this->getSelected());
    }

    public function resetIndex(): void
    {
        $this->index = 0;
    }
}
