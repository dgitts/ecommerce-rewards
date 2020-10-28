<?php

namespace Webkul\Admin\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\Customer\Repositories\CustomerRepository;

class PointsDataGrid extends DataGrid
{
    /**
     * @var string
     */
    public $index = 'timesheet_id';


    /**
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * CustomerRepository object
     *
     * @var object
     */
    protected $customerRepository;

    /**
     * Create a new datagrid instance.
     *
     * @param  Webkul\Customer\Repositories\CustomerRepository $customerRepository
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;

        parent::__construct();
    }

    public function prepareQueryBuilder()
    {
        $customer = $this->customerRepository->find(request('id'));

        $queryBuilder = DB::table('timesheets as ts')
            ->leftJoin('customers as c', 'ts.employee_id', '=', 'c.employee_id')
            ->addSelect('ts.id as timesheet_id', 'ts.week_ending', 'ts.hours')
            ->where('ts.processed', 1)
            ->where('ts.employee_id', $customer->employee_id);

        $this->addFilter('timesheet_id', 'ts.id');
        $this->addFilter('week_ending', 'ts.week_ending');
        $this->addFilter('hours', 'ts.hours');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'timesheet_id',
            'label'      => trans('ID'),
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
            'label'      => trans('Points'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper' => function ($value) {
                return '<span class="badge badge-md badge-success">'. $value->hours .'</span>';
            },
        ]);
    }

    public function prepareActions()
    {
//        $this->addAction([
//            'title'  => trans('admin::app.datagrid.edit'),
//            'method' => 'GET',
//            'route'  => 'admin.customer.addresses.edit',
//            'icon'   => 'icon pencil-lg-icon',
//        ]);
//
//        $this->addAction([
//            'title'        => trans('admin::app.datagrid.delete'),
//            'method'       => 'POST',
//            'route'        => 'admin.customer.addresses.delete',
//            'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'address']),
//            'icon'         => 'icon trash-icon',
//        ]);
    }

    public function prepareMassActions()
    {
//        $this->addMassAction([
//            'type'   => 'delete',
//            'label'  => trans('admin::app.customers.addresses.delete'),
//            'action' => route('admin.customer.addresses.massdelete', request('id')),
//            'method' => 'DELETE',
//        ]);
    }
}
