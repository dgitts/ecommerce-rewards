<?php

namespace App\Http\Controllers;

use App\Gamify\Points\PointModificationCreated;
use App\Http\Controllers\Controller;
use App\PointModification;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class PointsController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Customer Repository object
     *
     * @var \Webkul\Customer\Repositories\CustomerRepository
     */
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customer = $this->customerRepository->find($id);
        $pointsType = $this->_config['type'];
        $menu_items = [
            [
                'name' => 'Timesheets',
                'active' => $pointsType == 'timesheets' ? 'active' : '',
                'url' => route('admin.points.index', ['id' => $id]),
            ],
            [
                'name' => 'Point Modifications',
                'active' => $pointsType == 'point-modifications' ? 'active' : '',
                'url' => route('admin.points.modifications.index', ['id' => $id]),
            ]];

        return view($this->_config['view'], compact('customer', 'menu_items', 'pointsType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $customer = $this->customerRepository->find($id);
        $add_deduct = $this->_config['add_deduct'];

        return view($this->_config['view'], compact('customer', 'add_deduct'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = collect(request()->input())->except('_token')->toArray();

        $this->validate(request(), [
            'customer_id'  => 'required',
            'add_deduct'   => 'required',
            'points'       => 'required',
            'notes'        => 'required',
        ]);

        // Determine add/deduct boolean
        $data['add'] = 0;
        if ($data['add_deduct'] == 'Add') {
            $data['add'] = 1;
        }

        // Get employee id
        $customer = Customer::find($data['customer_id']);
        $data['employee_id'] = $customer->employee_id;

        $pointModification = PointModification::create($data);

        if ($data['add_deduct'] == 'Add') {
            $customer->givePoint(new PointModificationCreated($pointModification));
        } else {
            $customer->reducePoint($data['points']);
        }

        session()->flash('success', trans('app.points.success-create', ['action' => strtolower($data['add_deduct']) . 'ed']));

        return redirect()->route('admin.points.modifications.index', ['id' => $data['customer_id']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
