<?php

namespace Webkul\Admin\DataGrids;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use Webkul\Customer\Repositories\CustomerRepository;

class PointModificationsDataGrid extends DataGrid
{
    /**
     * @var string
     */
    public $index = 'id';


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

        $queryBuilder = DB::table('point_modifications as pm')
            ->leftJoin('customers as c', 'pm.employee_id', '=', 'c.employee_id')
            ->addSelect('pm.id as id', 'pm.add', 'pm.points', 'pm.notes', 'pm.created_at')
//            ->where('pm.processed', 1)
            ->where('pm.employee_id', $customer->employee_id);

        $this->addFilter('id', 'pm.id');
        $this->addFilter('add_deduct', 'pm.add');
        $this->addFilter('points', 'pm.points');
        $this->addFilter('notes', 'pm.notes');
        $this->addFilter('created_at', 'pm.created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('ID'),
            'type'       => 'number',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('Created'),
            'type'       => 'datetime',
            'sortable'   => true,
            'searchable' => false,
            'filterable' => true,
            'wrapper' => function ($value) {
                return Carbon::parse($value->created_at)->format('m/d/y h:i a');
            },
        ]);

        $this->addColumn([
            'index'      => 'notes',
            'label'      => trans('Notes'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'points',
            'label'      => trans('Points'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper' => function ($value) {
                if ($value->add) {
                    return '<span class="badge badge-md badge-success">'. $value->points .'</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">'. $value->points .'</span>';
                }
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
