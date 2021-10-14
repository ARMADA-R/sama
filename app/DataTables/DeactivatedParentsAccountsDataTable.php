<?php

namespace App\DataTables;

use App\Models\DeactivatedParentsAccount;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeactivatedParentsAccountsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            // ->addColumn('Action', 'admin.parents.action')
            ->rawColumns([
                'Action',
            ])
            ->setRowId(function ($parent) {
                return 'row_' . $parent->id;
            })
            ->editColumn('created_at', function ($record) {
                return $record->created_at ? with(new Carbon($record->created_at))->format('Y-m-d H:i') : '';
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DeactivatedParentsAccount $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DeactivatedParentsAccount $model)
    {
        return $model->select('parents.*', 'deactivated_parents_accounts.username', 'deactivated_parents_accounts.password')->join('parents', 'parents.id', '=', 'deactivated_parents_accounts.parent_id');
    }

    

    public function lang()
    {
        $langJson = [
            "sEmptyTable"     =>  trans('general.datatable.sEmptyTable'),
            "sInfo"           =>  trans('general.datatable.sInfo'),
            "sInfoEmpty"      =>  trans('general.datatable.sInfoEmpty'),
            "sInfoFiltered"   =>  trans('general.datatable.sInfoFiltered'),
            "sInfoPostFix"    =>  trans('general.datatable.sInfoPostFix'),
            "sInfoThousands"  =>  trans('general.datatable.sInfoThousands'),
            "sLengthMenu"     =>  trans('general.datatable.sLengthMenu'),
            "sLoadingRecords" =>  trans('general.datatable.sLoadingRecords'),
            "sProcessing"     =>  trans('general.datatable.sProcessing'),
            "sSearch"         =>  trans('general.datatable.sSearch'),
            "sZeroRecords"    =>  trans('general.datatable.sZeroRecords'),
            "sFirst"          =>  trans('general.datatable.sFirst'),
            "sLast"           =>  trans('general.datatable.sLast'),
            "sNext"           =>  trans('general.datatable.sNext'),
            "sPrevious"       =>  trans('general.datatable.sPrevious'),
            "sSortAscending"  =>  trans('general.datatable.sSortAscending'),
            "sSortDescending" =>  trans('general.datatable.sSortDescending'),
        ];
        return $langJson;
    }



    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('parents-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>')
            ->orderBy(1)

            ->buttons(
                Button::make('reset')->text(' <i class="fas fa-redo"></i> ' . trans('app.datatable.reset')),
                Button::make('reload')->text(' <i class="fas fa-sync-alt"></i> ' . trans('app.datatable.reload')),
            )->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, 100, 500], ['10', '25', '50', '100', '500']],

                'language' => $this->lang(),

            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')->title('#')
                ->addClass('text-center'),
            Column::make('first_name')->title(trans('general.First Name')),
            Column::make('last_name')->title(trans('general.Last Name')),
            Column::make('gender')->title(trans('general.gender')),
            Column::make('phone')->title(trans('general.phone')),
            Column::make('job')->title(trans('general.job')),
            Column::make('username')->title(trans('general.Username')),
                ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DeactivatedParentsAccounts_' . date('YmdHis');
    }
}
