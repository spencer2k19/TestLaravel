<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Show the lists of products added in cart
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();

        return view('home',compact('products'));
    }


    /**
     * Validate an order and generate a pdf file
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */


    public function  validateOrder(Request $request)
    {
     $cartItems = session()->get('cart');
     $user = User::findOrFail(Auth::id());
     $total = 0;
     foreach ($cartItems as $cartItem) {
         $prod = $cartItem->getProduct();
         $total += $prod->price * $cartItem->getQuantity();
     }

     $order = new Order();
     $order->total = $total;
     $order->ordered()->associate($user);
     $order->save();


     foreach ($cartItems as $cartItem) {
         $prod = $cartItem->getProduct();
         $order->products()->attach($prod,[
             'total'=>$prod->price * $cartItem->getQuantity(),
             'quantity'=> $cartItem->getQuantity()
         ]);
     }


     $products= $order->products()->withPivot('total','quantity')->get();

     //Generate pdf
        $pdf = PDF::loadView('pdfview',compact('products','order'));
        return  $pdf->download("invoice$order->id.pdf");



//     return redirect()->route('home');

    }



    /**
     * Add a single product(name and quantity) in cart
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function addToCart(Request $request)
    {
        $products = Product::all();
        $listCarts = [];

        if (session()->has('cart'))
        {
            $listCarts = session()->get('cart');
        }

        $this->validate($request,[
           'quantity'=>'required'
        ]);

        $product = Product::findOrFail($request->product);
        $cart = new Cart($product,$request->quantity);

        $listCarts[] = $cart;
        session()->put("cart",$listCarts);
        return redirect()->route('home');

    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->route('home');
    }




}
