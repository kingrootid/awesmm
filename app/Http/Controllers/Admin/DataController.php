<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Deposit;
use App\Models\Method;
use App\Models\News;
use App\Models\OrderRequest;
use App\Models\OrdersGames;
use App\Models\OrdersPpob;
use App\Models\OrdersSosmed;
use App\Models\Page;
use App\Models\Providers;
use App\Models\Role;
use App\Models\Services;
use App\Models\Tickets;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function __construct()
    {
        if (!request()->ajax()) {
            exit('Not allowed direct access >.<');
        }
    }
    public function news(Request $request)
    {
        return datatables()->of(News::query())->addIndexColumn()->editColumn('type', function ($info) {
            if ($info['type'] == "SERVICES") {
                $label = "info";
            } else if ($info['type'] == "PROMO") {
                $label = "success";
            } else if ($info['type'] == "MAINTENANCE") {
                $label = "danger";
            } else {
                $label = "warning";
            }
            $btn = "<span class='badge bg-$label'>" . $info['type'] . "</span>";
            return $btn;
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->editColumn('content', function ($row) {
            return stripslashes($row['content']);
        })->rawColumns(['action', 'type', 'content'])->make(true);
    }
    public function getNews($id)
    {
        return News::where('id', $id)->get()->first()->toArray();
    }
    public function deposits(Request $request)
    {
        $model = Deposit::query()->select('deposits.*', 'users.name as user_name')->join('users', 'users.id', '=', 'deposits.user_id');
        if (!is_null($request->status)) {
            $model = $model->where('status', $request->status);
        }
        $model->orderBy('deposits.id', 'desc');
        return datatables()->of($model)->editColumn('status', function ($info) {
            if ($info['status'] == "Success") {
                $label = "success";
            } else if ($info['status'] == "Canceled" || $info['status'] == "Refund") {
                $label = "danger";
            } else {
                $label = "warning";
            }
            $btn = "<span class='badge bg-$label'>" . $info['status'] . "</span>";
            return htmlspecialchars_decode($btn);
        })->editColumn('amount', function ($row) {
            return rupiah($row['amount']);
        })->editColumn('get', function ($row) {
            return rupiah($row['get']);
        })->editColumn('note', function ($row) {
            return "<span>" . nl2br($row['note']) . "</span>";
        })->editColumn('created_at', function ($row) {
            return $row['created_at']->format('d-m-Y H:i:s');
        })->addColumn('action', function ($row) {
            if ($row['status'] != "Success" and $row['status'] != "Canceled") {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-success' href='javascript:;' onclick='accept(" . $row['id'] . ")'><i class='fa fa-check''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='cancel(" . $row['id'] . ")'><i class='fa fa-times''></i></a>";
                return $actionBtn;
            } else {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-info' href='javascript:;' onclick='tarik(" . $row['id'] . ")'><i class='fas fa-hand-holding-usd'></i></a> ";
                return $actionBtn;
            }
        })->rawColumns(['status', 'action', 'note'])->make(true);
    }
    public function method(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Method::query())->addIndexColumn()->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->editColumn('note', function ($row) {
                return "<span>" . nl2br($row['note']) . "</span>";
            })->rawColumns(['note', 'action'])->make(true);
        }
    }
    public function getMethod($id)
    {
        return Method::where('id', $id)->get()->first()->toArray();
    }
    public function category(Request $request)
    {
        return datatables()->of(Categories::query())->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->editColumn('note', function ($row) {
                return nl2br($row['note']);
            })->rawColumns(['action'])->make(true);
    }
    public function getCategory($id)
    {
        return Categories::where('id', $id)->get()->first()->toArray();
    }
    public function provider(Request $request)
    {
        return datatables()->of(Providers::query())->addIndexColumn()
            // ->editColumn('photo', function ($row) {
            //     return "<img src='" . asset('images/smm/' . $row['photo']) . "' width='200px' height='200px' class='m-auto'>";
            // })
            ->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->rawColumns(['action'])->make(true);
    }
    public function getProvider($id)
    {
        return Providers::where('id', $id)->get()->first()->toArray();
    }
    public function services(Request $request)
    {
        $query = Services::query();
        if (!is_null($request->category)) {
            $query = $query->where('category_id', $request->category);
        }
        if (!is_null($request->provider)) {
            $query = $query->where('provider', $request->provider);
        }

        return datatables()->of($query)->addIndexColumn()
            ->editColumn('category_id', function ($row) {
                $data = Categories::where('id', $row['category_id'])->first();
                return (empty($data) ? 'Data tidak ditemukan' : $data->name);
            })
            ->editColumn('price', function ($row) {
                return rupiah($row['price']);
            })
            ->editColumn('profit', function ($row) {
                return rupiah($row['profit']);
            })
            ->addColumn('min_max', function ($row) {
                return $row['min'] . "/" . $row['max'];
            })->editColumn('provider', function ($row) {
                $data = Providers::where('id', $row['provider'])->first();
                return (empty($data) ? 'Data tidak ditemukan' : $data->name);
            })->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->editColumn('status', function ($row) {
                if ($row['status'] == 1) {
                    $label = "success";
                    $text = "Aktif";
                } else {
                    $text = "Tidak Aktif";
                    $label = "danger";
                }
                $btn = "<span class='badge rounded-pill bg-$label'>" . $text  . "</span>";
                return $btn;
            })->editColumn('is_canceled', function ($row) {
                if ($row['is_canceled'] == 1) {
                    $label = "success text-black";
                    $text = "YA";
                } else {
                    $text = "TIDAK";
                    $label = "danger text-white";
                }
                $btn = "<span class='badge bg-$label'>" . $text  . "</span>";
                return $btn;
            })->editColumn('is_refill', function ($row) {
                if ($row['is_refill'] == 1) {
                    $label = "success text-black";
                    $text = "YA";
                } else {
                    $text = "TIDAK";
                    $label = "danger text-white";
                }
                $btn = "<span class='badge bg-$label'>" . $text  . "</span>";
                return $btn;
            })->rawColumns(['status', 'action', 'is_canceled', 'is_refill'])->make(true);
    }
    public function getServices($id)
    {
        return Services::where('id', $id)->get()->first()->toArray();
    }
    public function history_sosmed(Request $request)
    {
        $model = OrdersSosmed::select('orders_sosmeds.*', 'users.name as users_name', 'providers.name as provider_name')->join('users', 'users.id', '=', 'orders_sosmeds.user_id')->join('providers', 'providers.id', '=', 'orders_sosmeds.provider')->orderBy('orders_sosmeds.id', 'desc');
        if (!is_null($request->status)) {
            $model = $model->where('status', $request->status);
        }
        return datatables()->of($model)->editColumn('status', function ($info) {
            if ($info['status'] == "Success") {
                $label = "success";
            } else if ($info['status'] == "Canceled" || $info['status'] == "Error" || $info['status'] == "Partial") {
                $label = "danger";
            } else if ($info['status'] == "Processing") {
                $label = "info";
            } else {
                $label = "warning";
            }
            $btn = "<span class='badge bg-$label'>" . $info['status'] . "</span>";
            return htmlspecialchars_decode($btn);
        })->editColumn('price', function ($row) {
            return rupiah($row['price']);
        })->editColumn('date', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->format('d-m-Y H:i:s');
        })->editColumn('from', function ($row) {
            if ($row['from'] == "web") {
                $from = "fas fa-globe text-info";
            } else {
                $from = "fas fa-random text-danger";
            }
            $html = "<center><i class='$from'></i></center>";
            return htmlspecialchars_decode($html);
        })->addColumn('detail', function ($row) {
            $btn = "<a class='btn btn-icon waves-effect btn-primary' href='javascript:;' onclick='detail(" . $row['id'] . ")'><i class='fa fa-eye'></i></a>";
            $btn .= "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit'></i></a>";
            return $btn;
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
        })->rawColumns(['status', 'from', 'detail'])->make(true);
    }
    public function users(Request $request)
    {
        $model = User::query();
        return datatables()->of($model)->addIndexColumn()->editColumn('email', function ($row) {
            return obfuscate_email($row['email']);
        })->editColumn('balance', function ($row) {
            return rupiah($row['balance']);
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
        })->addColumn('role', function ($row) {
            return Role::where('id', $row['role_id'])->first()->name;
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['email', 'action'])->make(true);
    }
    public function role(Request $request)
    {
        return datatables()->of(Role::query())->addIndexColumn()
            ->editColumn('total_spend', function ($row) {
                return rupiah($row['total_spend']);
            })
            ->editColumn('total_discount', function ($row) {
                return $row['total_discount'] . " %";
            })
            ->editColumn('bonus_deposit', function ($row) {
                return $row['bonus_deposit'] . " %";
            })
            ->editColumn('private', function ($row) {
                if ($row['private'] == 1) {
                    $label = "success text-black";
                    $text = "YA";
                } else {
                    $text = "TIDAK";
                    $label = "danger text-white";
                }
                $btn = "<span class='badge bg-$label'>" . $text  . "</span>";
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
                return $actionBtn;
            })->rawColumns(['action', 'private'])->make(true);
    }
    public function getUsers($id)
    {
        $model = User::where('id', $id)->first();
        return $model->toArray();
    }
    public function findrole($id)
    {
        $model = Role::query()->where('id', $id)->first();
        return $model->toArray();
    }
    public function tickets(Request $request)
    {
        $model = Tickets::query()->orderBy('id', 'desc');
        return datatables()->of($model)->addIndexColumn()->editColumn('user_id', function ($row) {
            return User::where('id', $row['user_id'])->first()->name;
        })->editColumn('status', function ($row) {
            if ($row['status'] == "Open") {
                $status = "<span class='badge bg-info'>Open</span>";
            } else if ($row['status'] == "Closed") {
                $status = "<span class='badge bg-danger'>Close</span>";
            }
            return htmlspecialchars_decode($status);
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->format('d-m-Y H:i:s');
        })->addColumn('action', function ($row) {
            if ($row['status'] == "Open") {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-info' href='javascript:;' onclick='reply(" . $row['id'] . ")'><i class='fa fa-comments''></i></a> ";
                $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='tutup(" . $row['id'] . ")'><i class='fa fa-times''></i></a>";
            } else {
                $actionBtn = '';
            }
            return $actionBtn;
        })->rawColumns(['status', 'action'])->make(true);
    }
    public function pages(Request $request)
    {
        return datatables()->of(Page::query())->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='" . url('/admin/pages/edit/' . $row['id']) . "'><i class='fa fa-edit''></i></a> ";
                return $actionBtn;
            })->rawColumns(['action'])->make(true);
    }
    public function OrderRequest()
    {
        $model = OrderRequest::select('order_requests.*', 'users.name as users_name', 'providers.name as provider_name')->join('users', 'users.id', '=', 'order_requests.user_id')->join('providers', 'providers.id', '=', 'order_requests.provider_id')->orderBy('order_requests.id', 'desc');
        return datatables()->of($model)->editColumn('status', function ($info) {
            if ($info['status'] == "Success") {
                $label = "success";
            } else if ($info['status'] == "Canceled" || $info['status'] == "Refund") {
                $label = "danger";
            }
            if ($info['status'] == "Process") {
                $label = "info";
            } else {
                $label = "warning";
            }
            $btn = "<span class='badge bg-$label'>" . $info['status'] . "</span>";
            return htmlspecialchars_decode($btn);
        })->editColumn('type', function ($info) {
            if ($info['type'] == "Refill") {
                $label = "info";
            } else if ($info['type'] == "Cancel") {
                $label = "danger";
            }
            $btn = "<span class='badge bg-$label'>" . $info['type'] . "</span>";
            return htmlspecialchars_decode($btn);
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->format('d-m-Y H:i:s');
        })->addColumn('detail', function ($row) {
            $btn = "<a class='btn btn-icon waves-effect btn-info mr-1' href='javascript:;' onclick='detail(" . $row['order_id'] . ")'><i class='fa fa-eye'></i></a>";
            $btn .= "<a class='btn btn-icon waves-effect btn-warning mr-1' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit'></i></a>";
            return $btn;
        })->rawColumns(['status', 'detail', 'type'])->make(true);
    }
    public function getOrderRequest($id)
    {
        return OrderRequest::where('id', $id)->first();
    }
}
