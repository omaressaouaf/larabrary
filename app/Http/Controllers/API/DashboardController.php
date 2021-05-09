<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Role;
use App\User;
use App\Genre;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function count()
    {
        $ordersCount = Order::count();
        $genresCount = Genre::count();
        $booksCount = Book::count();
        $usersCount = User::count();
        return response()->json([
            'ordersCount' => $ordersCount,
            'genresCount' => $genresCount,
            'booksCount' => $booksCount,
            'usersCount' => $usersCount,
        ]);
    }
    public function charts()
    {
        $lowStockCount = Book::where('stock', '<=', '5')->count();
        $highStockCount = Book::where('stock', '>', '5')->count();
        $shippedCount = Order::where('status', 'shipped')->count();
        $processingCount = Order::where('status', 'processing')->count();
        $deliveredCount = Order::where('status', 'delivered')->count();
        $clientsCount = Role::where('name', 'user')->first()->users()->count();
        $authorsCount = Role::where('name', 'author')->first()->users()->count();
        $adminsCount =  Role::where('name', 'admin')->first()->users()->count();
        $ordersByMonth = DB::table('orders')->selectRaw("
        count(id) AS total, 
        DATE_FORMAT(created_at, '%m') AS month, 
        MONTHNAME(created_at) AS month
    ")
            ->groupBy('month')
            ->get();
         

        return response()->json([
            'lowStockCount' => $lowStockCount,
            'highStockCount' => $highStockCount,
            'shippedCount' => $shippedCount,
            'processingCount' => $processingCount,
            'deliveredCount' => $deliveredCount,
            'clientsCount' => $clientsCount,
            'authorsCount' => $authorsCount,
            'adminsCount' => $adminsCount,
            'ordersByMonth' => $ordersByMonth,
        ]);
    }

}
