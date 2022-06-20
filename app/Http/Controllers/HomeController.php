<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Proceedings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $orders = Order::all();
        $proceedings = Proceedings::all();    
        return view('home', ['orders' => $orders, 'proceedings' => $proceedings]);
    }

    public function add()
    {
        return view('order/add');
    }

    public function save(Request $request){
        $request->validate([
            'description' => 'required|min:1',
            'amount' => 'required|min:1',
            'value' => 'required|min:1',
            'type' => 'required|min:1'
        ]);
        $order = new Order;
        $order->description = $request->description;
        $order->amount = $request->amount;
        $order->value = $request->value;
        $order->type = $request->type;
        $order->status = "GENERATED";
        $order->save();
        Session::flash('success', 'Order added correctly.');
        return redirect( route('home') );
    }

    public function delete($id){
        $order = Order::find($id);
        $order->delete();
        return redirect( route('home') )->with('success', 'Order deleted successfully');
    }

    public function show($id){
        $order = Order::find($id);
        return view('order/show', ['order' => $order]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'description' => 'required|min:1',
            'amount' => 'required|min:1',
            'value' => 'required|min:1',
            'type' => 'required|min:1'
        ]);
        $order = Order::find($id);
        $order->description = $request->description;
        $order->amount = $request->amount;
        $order->value = $request->value;
        $order->type = $request->type;
        $order->save();

        return redirect( route('home') )->with('success', 'Order updated successfully');
    }

    public function create($id)
    {
        $order = Order::find($id);
        $order->status = "PROCEEDINGS";
        $order->save();
        
        $proceedings = new Proceedings;
        $proceedings->number = "000-" . $order->id;
        $proceedings->user = Auth::user()->id;
        $proceedings->order = $order->id;
        $proceedings->save();
        return redirect( route('home') )->with('success', 'Proceedings created correctly');
    }

    public function finalize($id)
    {
        $order = Order::find($id);
        $order->status = "FINALIZED";
        $order->save();
        return redirect( route('home') )->with('success', 'Proceedings finalized correctly');
    }

    public function search($number){
        $proceedings = Proceedings::where('number', $number)->get();
        if($number == "000-"){
            $proceedings = Proceedings::all();    
        }        
        $orders = Order::all();
        return view('home', ['orders' => $orders, 'proceedings' => $proceedings]);
    }

    public function filter($status){
        if($status == "ALL"){
            $orders = Order::all();    
        }else{
            $orders = Order::where('status', $status)->get();
        }        
        $proceedings = Proceedings::all();
        return view('home', ['orders' => $orders, 'proceedings' => $proceedings]);
    }

}
