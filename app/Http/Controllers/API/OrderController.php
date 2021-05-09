<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Order;
use App\BookOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Order::with('user')->latest()->get();
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
        $this->validate($request, [
            'status' => "in:shipped,processing,delivered",
        ]);
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return response()->json([
            'message' => "Order has been updated",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json([
            'message' => "Order has been deleted",
        ], 200);
    }
    public function details($id)
    {
        $order = Order::find($id);
        $orderDetails = $order->detailsWithRemovedBooks();
        return response()->json([
            'order' => $order,
            'orderDetails' => $orderDetails
        ]);
    }

}
