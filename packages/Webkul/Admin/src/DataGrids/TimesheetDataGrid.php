<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class TimesheetDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    protected $itemsPerPage = 20;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('timesheets')
            ->addSelect('timesheets.id', 'employee_id', 'week_ending', 'hours', 'processed');

        $this->addFilter('id', 'id');
        $this->addFilter('employee_id', 'employee_id');
        $this->addFilter('week_ending', 'week_ending');
        $this->addFilter('hours', 'hours');
        $this->addFilter('processed', 'processed');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'employee_id',
            'label'      => trans('Employee ID'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'week_ending',
            'label'      => trans('Week Ending'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'hours',
            'label'      => trans('Hours'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'processed',
            'label'      => trans('Processed'),
            'type'       => 'boolean',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper'    => function ($row) {
                if ($row->processed == 1) {
                    return '<span class="badge badge-md badge-success">'. trans('Processed') .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. trans('Not processed') .'</span>';
                }
            },
        ]);
    }

//    public function prepareActions()
//    {
//        $this->addAction([
//            'method' => 'GET',
//            'route'  => 'admin.customer.edit',
//            'icon'   => 'icon pencil-lg-icon',
//            'title'  => trans('admin::app.customers.customers.edit-help-title'),
//        ]);
//
//        $this->addAction([
//            'type'   => 'Edit',
//            'method' => 'GET',
//            'route'  => 'admin.customer.addresses.index',
//            'icon'   => 'icon list-icon',
//            'title'  => trans('admin::app.customers.customers.addresses'),
//        ]);
//
//        $this->addAction([
//            'type'   => 'Points',
//            'method' => 'GET',
//            'route'  => 'admin.points.index',
//            'icon'   => 'icon search-icon',
//            'title'  => trans('app.customers.points'),
//        ]);
//
//        $this->addAction([
//            'method' => 'GET',
//            'route'  => 'admin.customer.note.create',
//            'icon'   => 'icon note-icon',
//            'title'  => trans('admin::app.customers.note.help-title'),
//        ]);
//
//        $this->addAction([
//            'method' => 'POST',
//            'route'  => 'admin.customer.delete',
//            'icon'   => 'icon trash-icon',
//            'title'  => trans('admin::app.customers.customers.delete-help-title'),
//        ]);
//    }

//    public function prepareMassActions()
//    {
//        $this->addMassAction([
//            'type'   => 'delete',
//            'label'  => trans('admin::app.datagrid.delete'),
//            'action' => route('admin.customer.mass-delete'),
//            'method' => 'PUT',
//        ]);
//
//        $this->addMassAction([
//            'type'    => 'update',
//            'label'   => trans('admin::app.datagrid.update-status'),
//            'action'  => route('admin.customer.mass-update'),
//            'method'  => 'PUT',
//            'options' => [
//                'Active'   => 1,
//                'Inactive' => 0,
//            ],
//        ]);
//    }
}