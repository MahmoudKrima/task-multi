<?php

namespace App\Http\Controllers\Admin\Home;

use App\Enum\PlanTransactionEnum;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Service;
use App\Models\Provider;
use App\Models\SubService;
use Illuminate\Http\Request;
use App\Enum\OrderStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\PlanTransaction;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.home.index');
    }
}
