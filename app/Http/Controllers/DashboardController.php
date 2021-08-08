<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Kanban;
use App\Models\Goods;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function __invoke(Request $request) {
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

        return view('dashboard', [
            'goods'=> Goods::count(), 
            'supplier'=> Supplier::count(), 
            'kanban'=> Kanban::whereYear('created_at', $year)->count(), 
            'order'=> Order::whereYear('created_at', $year)->count(), 
        ]);
    }
}
