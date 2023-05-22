<?php

namespace App\Http\Livewire\Ext\Forex;

use App\Models\Forex\ForexSignals;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class ForexSignalsTable extends DataTableComponent
{
    protected $model = ForexSignals::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setColumnSelectDisabled()
            ->setFilterLayoutSlideDown()
            ->setOfflineIndicatorEnabled()
            ->setEmptyMessage('No results found');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Title", "title")
                ->searchable()
                ->sortable(),
            BooleanColumn::make('Status')
                ->collapseOnMobile()
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Edit')
                        ->title(fn ($row) => 'Edit')
                        ->location(fn ($row) => route('admin.forex.edit', $row->id))
                        ->attributes(function ($row) {
                            return [
                                'class' => 'btn btn-outline-warning btn-sm',
                            ];
                        }),
                ]),
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Active')
                ->setFilterPillTitle('User Status')
                ->setFilterPillValues([
                    '1' => 'Active',
                    '0' => 'Inactive',
                ])
                ->options([
                    '' => 'All',
                    '1' => 'Yes',
                    '0' => 'No',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('status', true);
                    } elseif ($value === '0') {
                        $builder->where('status', false);
                    }
                }),
        ];
    }
    public function bulkActions(): array
    {
        return [
            'activate' => ['title' => 'Activate', 'icon' =>  'eye'],
            'deactivate' => ['title' => 'Deactivate', 'icon' =>  'eye-slash'],
            'delete' => ['title' => 'Delete', 'icon' =>  'x-lg'],
        ];
    }
    public function activate()
    {
        $names = '';
        $count = count($this->getSelected());
        foreach ($this->getSelected() as $id) {
            $item = ForexSignals::findOrFail($id);
            $names .= $item->id . ', ';
            $item->status = 1;
            $item->save();
        }
        Session::flash('alert', [
            'class' => 'success',
            'icon' => 'check-circle', /* danger: exclamation-triangle , success: check-circle, info: exclamation-circle */
            'header' => 'Alert!',
            'message' =>  '(' . rtrim($names, ", ") . ') ' . ($count > 1 ? 'Accounts' : 'Account') . ' Activated Successfully'
        ]);

        $this->clearSelected();
    }

    public function deactivate()
    {
        $names = '';
        $count = count($this->getSelected());
        foreach ($this->getSelected() as $id) {
            $item = ForexSignals::findOrFail($id);
            $names .= $item->id . ', ';
            $item->status = 0;
            $item->save();
        }
        Session::flash('alert', [
            'class' => 'danger',
            'icon' => 'exclamation-triangle',
            'header' => 'Alert!',
            'message' =>  '(' . rtrim($names, ", ") . ') ' . ($count > 1 ? 'Accounts' : 'Account') . ' Deactivated Successfully'
        ]);
        $this->clearSelected();
    }

    public function delete()
    {
        abort_if(Gate::denies('forex_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $names = '';
        $count = count($this->getSelected());
        foreach ($this->getSelected() as $id) {
            $item = ForexSignals::findOrFail($id);
            $names .= $item->id . ', ';
            $item->delete();
        }
        Session::flash('alert', [
            'class' => 'danger',
            'icon' => 'exclamation-triangle',
            'header' => 'Alert!',
            'message' =>  '(' . rtrim($names, ", ") . ') ' . ($count > 1 ? 'Accounts' : 'Account') . ' Removed Successfully'
        ]);
        $this->clearSelected();
    }
}