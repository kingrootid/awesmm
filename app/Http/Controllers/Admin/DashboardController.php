<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Config;
use App\Models\OrdersSosmed;
use App\Models\Page;
use App\Models\Providers;
use App\Models\Role;
use App\Models\TicketReply;
use App\Models\Tickets;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'page' => 'Halaman Admin',
            'user' => auth()->guard('admin')->user(),
        ];
        return view('admin.dashboard', $data);
    }
    public function news()
    {
        $data =  [
            'page' => 'Berita & Informasi',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.news', $data);
    }
    public function method()
    {
        $data =  [
            'page' => 'Method',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.method', $data);
    }
    public function history_deposits()
    {
        $data =  [
            'page' => 'User Deposits',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.history_deposit', $data);
    }
    public function category()
    {
        $data =  [
            'page' => 'Category',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.category', $data);
    }
    public function provider()
    {
        $data =  [
            'page' => 'Provider',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.provider', $data);
    }
    public function services()
    {
        $data =  [
            'page' => 'Layanan SMM',
            'user' => auth()->guard('admin')->user(),
            'category' => Categories::orderBy('name', 'asc')->get(),
            'provider' => Providers::all()
        ];
        return view('admin.services', $data);
    }
    public function category_images()
    {
        $data =  [
            'page' => 'Icon Category',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.category_images', $data);
    }
    public function history_social()
    {
        $data =  [
            'page' => 'History Social Media',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.history_social', $data);
    }
    public function history_request()
    {
        $data =  [
            'page' => 'History Social Media',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.history_request', $data);
    }
    public function history_ppob()
    {
        $data =  [
            'page' => 'History PPOB',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.history_ppob', $data);
    }
    public function history_games()
    {
        $data =  [
            'page' => 'History Topup Games',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.history_games', $data);
    }
    public function settings()
    {
        $data =  [
            'page' => 'Setting Website',
            'user' => auth()->guard('admin')->user(),
            'setting' => Config::all(),
        ];
        return view('admin.setting_var', $data);
    }
    public function users()
    {
        $data =  [
            'page' => 'Management User',
            'user' => auth()->guard('admin')->user(),
            'roles' => Role::all(),
        ];
        return view('admin.users', $data);
    }
    public function role()
    {
        $data =  [
            'page' => 'Management Role',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.role', $data);
    }
    public function tickets()
    {
        $data =  [
            'page' => 'Daftar Ticket',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.tickets.index', $data);
    }
    public function tickets_reply($id)
    {
        if (empty($id)) {
            return redirect()->back();
        } else {
            $ticket = Tickets::query()->where('id', $id)->first();
            $orderId = $ticket->order_id ? explode(',', $ticket->order_id) : null;
            $arrayData = array();
            if ($orderId) {
                $checkOrder = OrdersSosmed::select('orders_sosmeds.*', 'users.name as users_name', 'providers.name as provider_name')->join('users', 'users.id', '=', 'orders_sosmeds.user_id')->join('providers', 'providers.id', '=', 'orders_sosmeds.provider')->whereIn('orders_sosmeds.id', $orderId)->get();
                foreach ($checkOrder as $order) {
                    $arrayData[$order->provider_name][] = $order->order_id;
                }
            } else {
                $arrayData = array();
            }
            $data =  [
                'page' => 'Detail Tickets #' . $id,
                'user' => auth()->guard('admin')->user(),
                'ticket' => $ticket,
                'order_id' => $arrayData,
                'replies' => TicketReply::query()->where('ticket_id', $id)->get()->toArray(),
            ];
            return view('admin.tickets.reply', $data);
        }
    }
    public function faq()
    {
        $data =  [
            'page' => 'FAQ',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.faq', $data);
    }
    public function contact_us()
    {
        $data =  [
            'page' => 'Contact Us',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.contact_us', $data);
    }
    public function report_order()
    {
        $data =  [
            'page' => 'Report Order',
            'user' => auth()->guard('admin')->user(),
            'provider' => Providers::all()
        ];
        return view('admin.report', $data);
    }
    public function service_premium()
    {
        $data =  [
            'page' => 'Management Service Premium',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.service_premium', $data);
    }
    public function serviceHide()
    {
        $data =  [
            'page' => 'Hide Service',
            'user' => auth()->guard('admin')->user(),
            'provider' => Providers::query()->get(),
            'category' => Categories::query()->orderBy('name', 'asc')->get()
        ];
        return view('admin.hide_service', $data);
    }
    public function serviceRecommend()
    {
        $data =  [
            'page' => 'Services Recommended',
            'user' => auth()->guard('admin')->user(),
            'provider' => Providers::query()->get(),
            'category' => Categories::query()->orderBy('name', 'asc')->get()
        ];
        return view('admin.services_recommended', $data);
    }
    public function balance_provider()
    {
        $data =  [
            'page' => 'Saldo Provider',
            'user' => auth()->guard('admin')->user()
        ];
        return view('admin.balance_provider', $data);
    }
    public function pages()
    {
        $data = [
            'page' => 'Halaman',
            'user' => auth()->guard('admin')->user(),
        ];
        return view('admin.pages', $data);
    }
    public function editPages($id)
    {
        $dataPages = Page::where('id', $id)->first();
        if (empty($id)) {
            return back();
        } else if (empty($dataPages)) {
            return back();
        } else {
            $data = [
                'page' => 'Edit Pages',
                'user' => auth()->guard('admin')->user(),
                'pages' => $dataPages
            ];
            return view('admin.edit_pages', $data);
        }
    }
}
