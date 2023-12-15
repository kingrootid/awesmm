<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Deposit;
use App\Models\FavoriteServices;
use App\Models\Method;
use App\Models\News;
use App\Models\OrdersSosmed;
use App\Models\Page;
use App\Models\Role;
use App\Models\TicketReply;
use App\Models\Tickets;
use App\Models\Tripay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'Dashboard',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
            'deposit' => DB::table('deposits')->where('user_id', $user->id)->sum('amount'),
            'orders' => DB::table('orders_sosmeds')->where('user_id', $user->id)->sum('price'),
            'news' => News::orderBy('id', 'desc')->limit(5)->get()
        ];
        return view('dashboard', $data);
    }
    public function landing()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            $data = [
                'page' => 'Home',
                'orderCounts' => OrdersSosmed::count(),
                'userCounts' => User::count(),
                'depositCounts' => Deposit::count(),
            ];
            return view('index', $data);
        }
    }
    public function priceList()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'Daftar Harga Layanan Sosmed',
            'user' => $user,
            'category' => Categories::query()->orderBy('name', 'asc')->get()
        ];
        return view('price-list', $data);
    }
    public function pages($name)
    {
        if (empty($name)) {
            return back();
        } else {
            $checkPages = Page::where('pages', $name)->first();
            if (empty($checkPages)) {
                return back();
            } else {
                if ($checkPages['pages'] == "about-us") {
                    $name = "Hubungi Kami";
                } else if ($checkPages['pages'] == "terms-of-services") {
                    $name = "Ketentuan Layanan";
                } else if ($checkPages['pages'] == "privacy") {
                    $name = "Kebijakan Pribadi";
                } else if ($checkPages['pages'] == "contact-us") {
                    $name = "Hubungi Kami";
                }
                $data =  [
                    'page' => $name,
                    'content' => $checkPages['content'],
                ];
                return view('pages', $data);
            }
        }
    }
    public function singleOrder()
    {
        $user = Auth::user();
        $favCategory = FavoriteServices::select('favorite_services.*', 'categories.name as category')->where([
            'user_id' => $user->id,
        ])->join('categories', 'categories.id', '=', 'favorite_services.category_id')->groupBy('category_id')->get();
        $data =  [
            'page' => 'Pemesanan Baru Satuan',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
            'fav_category' => $favCategory
        ];
        return view('orders.single', $data);
    }
    public function historyOrder()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'Riwayat Pemesanan',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
        ];
        return view('orders.history', $data);
    }
    public function requestOrder()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'Riwayat Permintaan Pemesanan',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
        ];
        return view('orders.request', $data);
    }
    public function depositNew()
    {
        $user = Auth::user();
        $channel = [];
        $tripayChannel = Tripay::groupBy('group')->get();
        foreach ($tripayChannel as $tc) {
            $dataChannel = Tripay::where('group', $tc['group'])->get();
            $channel[$tc['group']] = $dataChannel;
        }
        $data =  [
            'page' => 'Deposit Baru',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
            'methods_internal' => Method::all(),
            'methods_external' => $channel
        ];
        return view('deposit.new', $data);
    }
    public function depositHistory()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'Riwayat Deposit',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
        ];
        return view('deposit.history', $data);
    }
    public function depositInvoice($id)
    {
        if (!$id) {
            return redirect()->route('dashboard');
        } else {
            $check = Deposit::where('id', $id)->first();
            if (!$check) {
                return redirect()->route('dashboard');
            } else {
                $user = User::where('id', $check->user_id)->first();
                $data =  [
                    'page' => 'Detail Deposit',
                    'user' => Auth::user(),
                    'role' => Role::where('id', Auth::user()->role_id)->first(),
                    'deposit' => $check,
                    'userInvoice' => $user
                ];
                return view('deposit.invoice', $data);
            }
        }
    }
    public function apiDocs()
    {
        $user = Auth::user();
        $data =  [
            'page' => 'API Dokumentasi',
            'user' => $user,
            'role' => Role::where('id', $user->role_id)->first(),
            'category' => Categories::all()
        ];
        return view('documentation', $data);
    }
    public function tickets()
    {
        $data =  [
            'page' => 'Data Ticket Bantuan',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first(),
        ];
        return view('tickets.index', $data);
    }
    public function ticketsReply($id)
    {
        if (empty($id)) {
            return redirect()->back();
        } else {
            $data =  [
                'page' => 'Detail Tickets #' . $id,
                'user' => Auth::user(),
                'role' => Role::where('id', Auth::user()->role_id)->first(),
                'ticket' => Tickets::query()->where('id', $id)->first(),
                'replies' => TicketReply::query()->where('ticket_id', $id)->get()->toArray(),
            ];
            return view('tickets.reply', $data);
        }
    }
    public function mutasi()
    {
        $data =  [

            'page' => 'Mutasi Saldo',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first()
        ];
        return view('logs.mutasi', $data);
    }
    public function login()
    {
        $data =  [

            'page' => 'Riwayat Login',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first()
        ];
        return view('logs.login', $data);
    }
    public function history()
    {
        $data =  [

            'page' => 'Riwayat Perubahan Layanan',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first()
        ];
        return view('logs.history', $data);
    }
    public function monitoring()
    {
        $data =  [
            'page' => 'Monitoring Layanan',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first()
        ];
        return view('logs.monitoring', $data);
    }
    public function userSetting()
    {
        $data =  [
            'page' => 'Pengaturan Akun',
            'user' => Auth::user(),
            'role' => Role::where('id', Auth::user()->role_id)->first()
        ];
        return view('user_settings', $data);
    }
}
