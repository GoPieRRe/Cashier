<?php

namespace App\Http\Controllers;

use App\Models\{
    Orders,
    Menu,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Alert;
use PDF;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = session('order_success');
        if ($order) {
            session::forget('order_success');
            toast('Pembelian barang berhasil', 'success');
        }
        $order = Orders::orderby('updated_at', 'ASC')->get();

        $i = 0;
        $a = 0;
        $count = [];
        $count_array = count($order);
        $check = [];
        foreach ($order as $item) {
            $check[$i]['id'] = $order[$i]['id'];
            $check[$i]['id_costumer'] = $order[$i]['id_costumers'];
            $check[$i]['count'] = count($order[$i]['data']) - 2;
            $check[$i]['data'] = $order[$i]['data'];
            $check[$i]['total_price'] = $order[$i]['total_price'];
            $check[$i]['status'] = $order[$i]['status'];
            $check[$i]['created_at'] = $order[$i]['created_at']->diffForHumans();
            $check[$i]['updated_at'] = $order[$i]['updated_at']->diffForHumans();
            $i++;
        }
        return view('order.index', compact('check', 'order'));
    }

    public function updateStatus($id) {
        $order = Orders::find($id);
        $status = $order->status;
        switch ($status) {
            case 'order':
                $result = DB::table('orders')->where('id',$id)->update([
                    'status' => 'proses',
                    'updated_at' => Carbon::now(),
                ]);
                if ($result) {
                    toast('Status updated!', 'success');
                    return redirect()->back();
                }
                break;
            
            case 'proses':
                $result = DB::table('orders')->where('id',$id)->update([
                    'status' => 'finish',
                    'updated_at' => Carbon::now(),
                ]);
                if ($result) {
                    toast('Status updated!', 'success');
                    return redirect()->back();
                }

                break;
            
            default:
                toast('Status Update unSuccessfuly!', 'error');
                return back();
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartItems = session('cart');

        $cart = [];
        $i = 0;
        foreach ($cartItems as $key => $value) {
            $cart[$i]['id'] = $key;
            $cart[$i]['qty'] = $value;
            $i++;
        }

        $menu = Menu::whereIn('id', array_keys($cartItems))->get();

        $result = [];
        $total = 0;
        $a = 0;
        foreach ($menu as $m) {
            foreach ($cart as $c) {
                if ($m['id'] == $c['id']) {
                    $result['costumer'] = $request->costumer;
                    $result[$a]['product_name'] = $m->name; 
                    $result[$a]['price'] = $m->price; 
                    $result[$a]['discount'] = $m->discount; 
                    $result[$a]['total_price_product'] = $m->total_price; 
                    $result[$a]['quantity'] = $c['qty'];
                    $result[$a]['sub_total'] = $c['qty'] * $m->total_price;
                }
            }
            $total += $result[$a]['sub_total'];
            $a++; 
        }
        $data = [];
        // get costumer id
        $uuid = str::uuid('5');
        
        $data = [
            'id_costumers' => $uuid,
            'data' => $result,
            'total_price' => $total
        ];

        
        Session::forget('cart');
        Session::put('order_success', true);
        $check = Orders::create($data);
        if ($check) {
            return redirect()->route('order.invoice');
        }
        
    }

    public function invoice() {
        
        $order = Orders::orderBy('id', 'DESC')->first();
        $data = $order['data'];
        $ID = $order['id'];
        $orderId = $order['id_costumers'];
        $total = $order['total_price'];
        $count = count($data) - 2;

        $result = [];
        foreach ($data as $item) {
            for ($i=0; $i <= $count; $i++) { 
                $result[$i]['product_name'] = $data[$i]['product_name'];
                $result[$i]['price'] = $data[$i]['price'];
                $result[$i]['discount'] = $data[$i]['discount'];
                $result[$i]['quantity'] = $data[$i]['quantity'];
                $result[$i]['total_price_product'] = $data[$i]['total_price_product'];
                $result[$i]['sub_total'] = $data[$i]['sub_total'];
                $costumer = $data['costumer'];
            }
        }
        
        $pdf = PDF::loadView('order.invoice', compact('result', 'orderId', 'total', 'costumer', 'count', 'ID'));
        
        $name = date('Y-m-D H:i:s',time());
        return $pdf->download($name . '.pdf');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }


    public function ordering(){
        $menu = Menu::where('status', true)->get();
        return view('order.order', compact('menu'));
    }

    function checkout(Request $request) {
        $cartItems = session('cart');

        
        if (!$cartItems) {
            toast('Anda belum memilih apapun', 'error');
            return redirect()->back();
        }else{
            
            $menu = Menu::whereIn('id', array_keys($cartItems))->get();

            $cek = [];
            $i= 0;
            foreach ($cartItems as $key => $value) {
                $cek[$i]['id'] = $key;
                $cek[$i]['quantity'] = $value;
                $i++;
            }

            $result = [];
            $a = 0;
            foreach ($menu as $m) {
                foreach ($cek as $c) {
                    if ($m['id'] == $c['id']) {
                        $result[$a]['id'] = $m->id;
                        $result[$a]['product_name'] = $m->name; 
                        $result[$a]['quantity'] = $c['quantity']; 
                        $result[$a]['price'] = intVal($m->total_price); 
                        $result[$a]['total_price'] = $m->total_price * $c['quantity']; 
                    }
                }
                $a++;
            }

            
            return view('order.checkout', compact('result', 'cartItems'));
        }
    }

    function addToCart(Request $request) {
        // Retrieve the product ID and quantity from the request
        $productId = $request->id;
        $quantity = $request->quantity;

        $menu = Menu::where('id', $productId)->first();

        // Retrieve the cart items from the session or cookie
        $cartItems = session('cart', []);

        // Update the cart items with the new product and quantity
        if (array_key_exists($productId, $cartItems)) {
            $cartItems[$productId] += intVal($quantity);
        } else {
            $cartItems[$productId] = intval($quantity);
        }
        

        // Store the updated cart items in the session or cookie
        session(['cart' => $cartItems]);

        $check = session('cart');
        if ($check) {
            toast($menu->name . " Berhasil ditambahkan", 'success');
            return redirect()->route('order.buy');
        }else{
            toast($menu->name . " gagal ditambahkan", 'error');
            return redirect()->route('order.buy');

        }
    }

    public function increment(Request $request)
    {
        $productId = $request->input('product_id');

        $menu = Menu::where('id', $productId)->first();
        $cartItems = session('cart', []);

        if (array_key_exists($productId, $cartItems)) {
            $cartItems[$productId]++;
        } else {
            // If the product is not already in the cart, add it with quantity 1
            $cartItems[$productId] = 1;
        }

        session(['cart' => $cartItems]);

        return response()->json([
            'quantity' => $cartItems[$productId],
            'price' => $menu->total_price
        ]);
    }

    public function decrement(Request $request)
    {
        $productId = $request->input('product_id');

        $cartItems = session('cart', []);

        if (array_key_exists($productId, $cartItems)) {
            if ($cartItems[$productId] > 1) {
                $cartItems[$productId]--;
            } else {
                unset($cartItems[$productId]);
            }
        }

        session(['cart' => $cartItems]);

        return response()->json(['quantity' => $cartItems[$productId] ?? 0]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
