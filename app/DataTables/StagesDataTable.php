<?php

namespace App\DataTables;

use App\Models\Stage;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StagesDataTable extends DataTable
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
            ->addColumn('Action', 'admin.stages.action')
            ->rawColumns([
                'Action',
            ])
            ->setRowId(function ($record) {
                return 'row_' . $record->id;
            })
            ->editColumn('updated_at', function ($record) {
                return $record->updated_at ? with(new Carbon($record->updated_at))->format('Y-m-d H:i') : '';
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Stage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Stage $model)
    {
        return $model->newQuery();
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
            ->setTableId('stages-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>')
            ->orderBy(1)
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50,], ['10', '25', '50',]],
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
            Column::make('title')->title(trans('general.title')),
            Column::make('code')->title(trans('general.code')),
            Column::make('updated_at')->title(trans('general.updated-at')),
            Column::computed('Action')->title(trans('general.options'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->searchable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Stages_' . date('YmdHis');
    }
}



// 'buttons' => [
                //     [
                //         'extend' => 'collection',
                //         'className' => 'btn btn-outline-secondary dropdown-toggle me-2',
                //         'text' =>  'Export',
                //         'buttons' => [
                //             [
                //                 'extend' => 'print',
                //                 'text' =>  'Print',
                //                 'className' => 'dropdown-item',
                //                 'exportOptions' => [
                //                     'columns' => [3, 4, 5, 6, 7]
                //                 ]
                //             ],
                //             [
                //                 'extend' => 'csv',
                //                 'text' =>  'Csv',
                //                 'className' => 'dropdown-item',
                //                 'exportOptions' => [
                //                     'columns' => [3, 4, 5, 6, 7]
                //                 ]
                //             ],
                //             [
                //                 'extend' => 'excel',
                //                 'text' =>  'Excel',
                //                 'className' => 'dropdown-item',
                //                 'exportOptions' => [
                //                     'columns' => [3, 4, 5, 6, 7]
                //                 ]
                //             ],
                //             [
                //                 'extend' => 'pdf',
                //                 'text' =>  'Pdf',
                //                 'className' => 'dropdown-item',
                //                 'exportOptions' => [
                //                     'columns' => [3, 4, 5, 6, 7]
                //                 ]
                //             ],
                //             [
                //                 'extend' => 'copy',
                //                 'text' =>  'Copy',
                //                 'className' => 'dropdown-item',
                //                 'exportOptions' => [
                //                     'columns' => [3, 4, 5, 6, 7]
                //                 ]
                //             ]
                //         ],

                //     ],
                //     [
                //         'text' => 'Add New Record',
                //         'className' => 'create-new btn btn-primary',
                //         'attr' => [
                //             'data-bs-toggle' => 'modal',
                //             'data-bs-target' => '#modals-slide-in'
                //         ],
                //     ]
                // ],