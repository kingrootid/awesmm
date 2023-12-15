<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Deposit;
use App\Models\LoginLogs;
use App\Models\OrderRequest;
use App\Models\OrdersSosmed;
use App\Models\Services;
use App\Models\Tickets;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function __construct()
    {
        if (!request()->ajax()) {
            exit('Not allowed direct access >.<');
        }
        Carbon::setLocale('id');
    }
    public function priceSocial(Request $request)
    {
        $query = Services::query()->select('services.id as id', 'categories.name as category', 'services.name as name', 'services.description as description', 'services.price as price', 'services.min as min', 'services.max as max', 'services.type as type')->join('categories', 'services.category_id', '=', 'categories.id')->where([['services.category_id', '!=', 0], ['services.status', '!=', 0]]);
        if (!is_null($request->filter_order) && !is_null($request->urutan)) {
            $query = $query->orderBy($request->filter_order, $request->urutan);
        } else {
            $query = $query->orderBy('price', 'asc');
        }
        if (!is_null($request->category)) {
            $query = $query->where('category_id', $request->category);
        }
        return datatables()->of($query)->addIndexColumn()->editColumn('price', function ($row) {
            return rupiah($row['price']);
        })->addColumn('detail', function ($row) {
            $detail = "<a class='btn btn-icon waves-effect btn-primary' href='javascript:;' onclick='detail(" . $row['id'] . ")'><i class='fa fa-eye''></i></a>";
            return $detail;
        })->addColumn('favorite', function ($row) {
            if (favServices($row['id']) == 1) {
                $detail = "<a href='javascript:;' onclick='fav(" . $row['id'] . ")'><i class='fas fa-star text-primary''></i></a>";
            } else {
                $detail = "<a href='javascript:;' onclick='fav(" . $row['id'] . ")'><i class='far fa-star''></i></a>";
            }
            return $detail;
        })->addColumn('avg_time', function ($row) {
            $data = OrdersSosmed::query()->select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF( updated_at, created_at ))) AS timediff,service_name,quantity'))->where('service_name', $row->name)->groupBy('service_name')->first();
            return !$data ? 'Data tidak ditemukan' : CarbonInterval::seconds((int) $data->timediff)->cascade()->forHumans();
        })->orderColumn('name', function ($query, $order) {
            $query->orderBy('status', $order);
        })->rawColumns(['price', 'detail', 'avg_time', 'favorite'])->make(true);
    }
    public function orderHistory(Request $request)
    {
        $user = Auth::user();
        $model = OrdersSosmed::select('orders_sosmeds.*', 'users.name as users_name', 'providers.name as provider_name')->join('users', 'users.id', '=', 'orders_sosmeds.user_id')->join('providers', 'providers.id', '=', 'orders_sosmeds.provider')->where('user_id', $user->id)->orderBy('orders_sosmeds.id', 'desc');
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
            $btn = "<a class='btn btn-icon waves-effect btn-info mr-1' href='javascript:;' onclick='detail(" . $row['id'] . ")'><i class='fa fa-eye'></i></a>";
            if ($row['is_canceled']) {
                $user = Auth::user();
                $checkRequest = OrderRequest::where([
                    ['user_id', $user->id],
                    ['order_id', $row['id']],
                    ['type', 'Cancel']
                ])->first();
                if (!$checkRequest) {
                    $btn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='cancel(" . $row['id'] . ")'><i class='fa fa-times'></i></a>";
                }
            }
            if ($row['is_refill']) {
                $user = Auth::user();
                $checkRequest = OrderRequest::where([
                    ['user_id', $user->id],
                    ['order_id', $row['id']],
                    ['type', 'Refill']
                ])->first();
                if (!$checkRequest) {
                    $btn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='refill(" . $row['id'] . ")'><i class='fa fa-history'></i></a>";
                }
            }
            return $btn;
        })->editColumn('created_at', function ($row) {
            return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
        })->rawColumns(['status', 'from', 'detail'])->make(true);
    }
    public function depositHistory(Request $request)
    {
        $users = Auth::user();
        $model = Deposit::query()->where('user_id', $users['id'])->orderBy('id', 'desc');
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
            return htmlspecialchars($row['note']);
        })->editColumn('created_at', function ($row) {
            return $row['created_at']->format('d-m-Y H:i:s');
        })->addColumn('detail', function ($row) {
            // $btn = "<a class='btn btn-icon waves-effect btn-primary mr-2' href='javascript:;' onclick='detail(" . $row['id'] . ")'><i class='fa fa-eye'></i></a>";
            $btn = "<a class='btn btn-icon waves-effect btn-success' href='javascript:;' onclick='invoice(" . $row['id'] . ")'><i class='fas fa-receipt'></i></a>";
            return $btn;
        })->rawColumns(['status', 'detail'])->make(true);
    }
    public function tickets(Request $request)
    {
        $users = Auth::user();
        $model = Tickets::query()->where('user_id', $users['id'])->orderBy('id', 'desc');
        return datatables()->of($model)->addIndexColumn()->editColumn('status', function ($row) {
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
    public function monitoring(Request $request)
    {
        $model = OrdersSosmed::query()->select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF( updated_at, created_at ))) AS timediff,service_name,quantity'))->whereNotIn('status', ['Pending'])->groupBy('service_name')->orderBy('timediff', 'asc');
        return datatables()->of($model)->addIndexColumn()->editColumn('timediff', function ($row) {
            return CarbonInterval::seconds((int) $row['timediff'])->cascade()->forHumans();
        })->editColumn('service_name', function ($row) {
            return $row['service_name'];
        })->editColumn('quantity', function ($row) {
            return $row['quantity'];
        })->rawColumns(['timediff', 'service_name', 'quantity'])->make(true);
    }
    public function mutasi(Request $request)
    {
        if ($request->ajax()) {
            $users = Auth::user();
            $model = Activity::query()->where('user_id', $users['id'])->orderBy('id', 'desc');
            return datatables()->of($model)->editColumn('type', function ($row) {
                if ($row['type'] == "minus") {
                    $type = "Pengurangan";
                    $label = "danger";
                } else {
                    $type = "Penambahan";
                    $label = "success";
                }
                $btn = "<badge class='badge badge-pill bg-$label'>$type</badge>";
                return $btn;
            })->editColumn('amount', function ($row) {
                return rupiah($row['amount']);
            })->editColumn('note', function ($row) {
                return htmlspecialchars($row['note']);
            })->editColumn('created_at', function ($row) {
                return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
            })->rawColumns(['type'])->make(true);
        }
    }
    public function login(Request $request)
    {
        if ($request->ajax()) {
            $users = Auth::user();
            $model = LoginLogs::query()->where('user_id', $users['id'])->orderBy('id', 'desc');
            return datatables()->of($model)->editColumn('created_at', function ($row) {
                return Carbon::createFromTimeStamp(strtotime($row['created_at']))->diffForHumans();
            })->make(true);
        }
    }
    public function OrderRequest()
    {
        $users = Auth::user();
        $model = OrderRequest::query()->where('user_id', $users['id'])->orderBy('id', 'desc');
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
            return $btn;
        })->rawColumns(['status', 'detail', 'type'])->make(true);
    }
}
