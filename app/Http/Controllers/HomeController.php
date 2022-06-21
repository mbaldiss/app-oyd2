<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Proceedings;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

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

     // all
    public function index(){
        $orders = Order::all();
        $proceedings = Proceedings::all();    
        return view('home', ['orders' => $orders, 'proceedings' => $proceedings]);
    }

    // solicitor
    public function add()
    {
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('add', $user);
        if ($response->allowed()) {
            return view('order/add');
        } else {
            echo $response->message();
        }
    }

    // solicitor
    public function save(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('save', $user);
        if ($response->allowed()) {
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
        } else {
            echo $response->message();
        }
    }

    // solicitor
    public function delete($id){
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('delete', $user);
        if ($response->allowed()) {
            $order = Order::find($id);
            $order->delete();
            return redirect( route('home') )->with('success', 'Order deleted successfully');
        } else {
            echo $response->message();
        }
    }

    // solicitor
    public function show($id){
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('show', $user);
        if ($response->allowed()) {
            $order = Order::find($id);
            return view('order/show', ['order' => $order]);
        } else {
            echo $response->message();
        }
    }

    // solicitor
    public function update(Request $request, $id){
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('update', $user);
        if ($response->allowed()) {
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
        } else {
            echo $response->message();
        }
        
    }

    // authorizer
    public function create($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('create', $user);
        if ($response->allowed()) {
            $order = Order::find($id);
            $order->status = "PROCEEDINGS";
            $order->save();
            
            $proceedings = new Proceedings;
            $proceedings->number = "000-" . $order->id;
            $proceedings->user = Auth::user()->id;
            $proceedings->order = $order->id;
            $proceedings->save();
            return redirect( route('home') )->with('success', 'Proceedings created correctly');
        } else {
            echo $response->message();
        }
    }

    // authorizer
    public function finalize($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $response = Gate::inspect('finalize', $user);
        if ($response->allowed()) {
            $order = Order::find($id);
            $order->status = "FINALIZED";
            $order->save();
            return redirect( route('home') )->with('success', 'Proceedings finalized correctly');
        } else {
            echo $response->message();
        }
    }

    // all
    public function search($number){
        $proceedings = Proceedings::where('number', $number)->get();
        if($number == "000-"){
            $proceedings = Proceedings::all();    
        }        
        $orders = Order::all();
        return view('home', ['orders' => $orders, 'proceedings' => $proceedings]);
    }

    // all
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
