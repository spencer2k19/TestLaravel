@extends('layouts.app')

@section('content')
   <div class="container">
       <table class="table table-bordered table-hover">
           <thead class="thead-dark">
           <tr>
               <th scope="col">Product</th>
               <th scope="col">Quantity</th>
               <th scope="col">Total amount</th>
           </tr>
           </thead>
           <tbody>
           @if(session()->has('cart'))
                @foreach(session()->get('cart') as $cartItem)
                    <tr>
                        <th scope="row">{{$cartItem->getProduct()->name}}</th>
                        <td>{{$cartItem->getQuantity()}}</td>
                        <td>{{$cartItem->getQuantity() * $cartItem->getProduct()->price}}$</td>
                    </tr>

                    @endforeach
                @endif


           </tbody>
       </table>


       <div class="row col-lg-6 " >
           <button type="button" class="btn btn-primary" data-toggle="modal"
                   data-target="#add_invoice">Add an product</button>


           <div class="col-md-1"></div>
           @if(session()->has('cart'))
               <button type="button" data-toggle="modal" data-target="#validateOrder"  class="btn btn-secondary" >Validate and get invoice</button>
               <div class="col-sm-1"></div>
               <a href="{{route('clear')}}" type="button"  class="btn btn-danger" >Clear order</a>
           @endif


       </div>




       <!-- Modal to add an product to cart -->
       <div class="modal fade" id="add_invoice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Add an invoice</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <form action="{{route('addToCart')}}" method="POST">
                           @csrf
                           <div class="form-group">
                               <label for="product_name">Product</label>
                               <select class="form-control" id="product_name" name="product">
                                   @foreach($products as $product)

                                       <option value="{{$product->id}}">{{$product->name}} - {{$product->price}}$</option>

                                       @endforeach



                               </select>
                               @error('nom')
                               <div class="invalid-feedback">{{ $message }}</div>
                               @enderror
                           </div>
                           <div class="form-group">
                               <input type="number" class="form-control  @error('quantity') is-invalid @enderror" name="quantity" id="quantity" placeholder="Quantity" value="{{ old('quantity') }}">
                               @error('email')
                               <div class="invalid-feedback">{{ $message }}</div>
                               @enderror
                           </div>

                           <button type="submit" class="btn btn-secondary">Envoyer !</button>
                       </form>
                   </div>

               </div>
           </div>
       </div>





       <!--  Modal to confirm invoice generation-->

       <div class="modal fade" id="validateOrder" tabindex="-1" aria-labelledby="validateOrder" aria-hidden="true">
               <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h5 class="modal-title">Invoice generation</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   <div class="modal-body">
                       <p>Validate this order ?</p>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <form action="{{route('order')}}" method="post">
                           @csrf
                           <button type="submit"  class="btn btn-primary" >Validate and get invoice</button>
                       </form>
                   </div>
               </div>
           </div>
       </div>














   </div>
@endsection
