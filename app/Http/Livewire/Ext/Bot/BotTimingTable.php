<?php

namespace App\Http\Livewire\Ext\Bot;

use App\Models\Bot\BotTiming;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class BotTimingTable extends DataTableComponent
{

    protected $model = BotTiming::class;

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
            Column::make("Bot", "bot_id")
                ->searchable()
                ->collapseOnTablet()
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => '<a href="' . route('admin.bot.edit', $row->bot_id) . '" class="badge bg-light-danger">' . ucfirst($row->bot->title) . '</a>'
                )
                ->html(),
            Column::make("Duration", "duration")
                ->searchable()
                ->collapseOnMobile()
                ->sortable(),
            Column::make("Type", "type")
                ->searchable()
                ->collapseOnMobile()
                ->sortable(),
            BooleanColumn::make('Status')
                ->collapseOnMobile()
                ->sortable(),
            Column::make("Actions", "id")
                ->collapseOnMobile()
                ->format(
                    fn ($value, $row, Column $column) => "<button type='button' data-bs-toggle='modal' data-bs-target='#editModal' data-id='" . $row->id . "' data-duration='" . $row->duration . "' class='edit btn btn-outline-warning btn-sm'>Edit</button>"
                )
                ->html(),
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
        foreach ($this->getSelected() as $id) {
            $item = BotTiming::findOrFail($id);
            $item->status = 1;
            $item->save();
        }
        Session::flash('alert', [
            'class' => 'success',
            'icon' => 'check-circle', /* danger: exclamation-triangle , success: check-circle, info: exclamation-circle */
            'header' => 'Alert!',
            'message' => 'Bot Timing Activated Successfully'
        ]);

        $this->clearSelected();
    }

    public function deactivate()
    {
        foreach ($this->getSelected() as $id) {
            $item = BotTiming::findOrFail($id);
            $item->status = 0;
            $item->save();
        }
        Session::flash('alert', [
            'class' => 'danger',
            'icon' => 'exclamation-triangle',
            'header' => 'Alert!',
            'message' =>  'Bot Timing Deactivated Successfully'
        ]);
        $this->clearSelected();
    }

    public function delete()
    {
        abort_if(Gate::denies('bot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        foreach ($this->getSelected() as $id) {
            $item = BotTiming::findOrFail($id);
            $item->delete();
        }
        Session::flash('alert', [
            'class' => 'danger',
            'icon' => 'exclamation-triangle',
            'header' => 'Alert!',
            'message' =>  'Bot Timing Removed Successfully'
        ]);
        $this->clearSelected();
    }
}