<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use App\Gamify\Points\PointModificationCreated;
use App\PointModification;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Repositories\OrderRepository;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $order = $this->orderRepository->findOrFail($id);

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Cancel action for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $result = $this->orderRepository->cancel($id);

        if ($result) {
            // Reverse points
            $order = $this->orderRepository->findOrFail($id);
            $customer = Customer::find($order->customer_id);
            $pointModification = PointModification::create([
                'employee_id' => $customer->employee_id,
                'points' => intval($order->base_grand_total),
                'notes' => 'Admin canceled order # ' . $order->id,
                'add' => 1
            ]);
            $customer->givePoint(new PointModificationCreated($pointModification));

            session()->flash('success', trans('admin::app.response.cancel-success', ['name' => 'Order']));
        } else {
            session()->flash('error', trans('admin::app.response.cancel-error', ['name' => 'Order']));
        }

        return redirect()->back();
    }
}