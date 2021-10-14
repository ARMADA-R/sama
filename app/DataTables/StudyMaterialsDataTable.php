<?php

namespace App\DataTables;

use App\Models\StudyMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudyMaterialsDataTable extends DataTable
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
            ->addColumn('Action', 'admin.study-materials.action')
            ->rawColumns([
                'Action',
                'attachments',
            ])
            ->setRowId(function ($record) {
                return 'row_' . $record->id;
            })
            ->editColumn('updated_at', function ($record) {
                return $record->updated_at ? with(new Carbon($record->updated_at))->format('Y-m-d H:i') : '';
            })
            ->editColumn('attachments', function ($record) {
                return $record->attachments ? '
                <a class="action-row" title="'.trans("general.download").'" href="' . Storage::url($record->attachments) . '">
                <i class="fas fa-cloud-download-alt"></i> '.trans("general.download").'
                </a>' : trans("general.nothing");
            })
            ->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StudyMaterial $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StudyMaterial $model)
    {
        return $model->select('study_materials.*', 'levels.title as level', 'stages.title as stage')
            ->join('levels', 'levels.id', '=', 'study_materials.level_id')
            ->join('stages', 'stages.id', '=', 'levels.stage_id');
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
            ->setTableId('studymaterials-table')
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
            Column::make('stage')->title(trans('general.stage')),
            Column::make('level')->title(trans('general.level')),
            Column::make('max_grade')->title(trans('general.max_grade')),
            Column::make('min_grade')->title(trans('general.min_grade')),
            Column::make('attachments')->title(trans('general.attachments'))
                ->addClass('text-center'),
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
        return 'StudyMaterials_' . date('YmdHis');
    }
}
