<?php

namespace App\Http\Controllers;

use App\Library\Tripay as LibraryTripay;
use App\Models\Activity;
use App\Models\Categories;
use App\Models\Deposit;
use App\Models\FavoriteServices;
use App\Models\Method;
use App\Models\OrderRequest;
use App\Models\OrdersSosmed;
use App\Models\Providers;
use App\Models\Role;
use App\Models\Services;
use App\Models\TicketReply;
use App\Models\Tickets;
use App\Models\Tripay;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{
    public function showCategory(Request $request)
    {
        try {
            if ($request['category'] == "0") {
                $data = Categories::orderBy('name', 'asc')->get()->toArray();
            } else {
                $data = Categories::where('name', 'LIKE', '%' . $request['category'] . '%')->orderBy('name', 'asc')->get()->toArray();
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $data
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function FavoriteServices(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'service' => 'required',
            ], [
                'service.required' => 'Anda belum memilih layanan'
            ]);
            $user = Auth::user();
            if (empty($user)) throw new \ErrorException('Anda belum login, silahkan login terlebih dahulu');

            $check = FavoriteServices::where([
                ['user_id', $user->id],
                ['service_id', $validate['service']]
            ])->first();
            $service = Services::where([
                ['id', $validate['service']],
                ['status', 1]
            ])->first();
            if (!$service) throw new \ErrorException('Layanan sedang tidak aktif');
            if (!$check) {
                $insert = FavoriteServices::create([
                    'user_id' => $user->id,
                    'category_id' => $service['category_id'],
                    'service_id' => $service->id
                ]);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Layanan ke Favorit');
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Menambahkan Layanan ke Favorit'
                ]);
            } else {
                $delete = FavoriteServices::where('id', $check['id'])->delete();
                if (!$delete) throw new \ErrorException('Gagal Menghapus Layanan ke Favorit');
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Menghapus Layanan ke Favorit'
                ]);
            }
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function getServices(Request $request)
    {
        try {
            $validateData = $this->validate(
                $request,
                [
                    'category' => 'required|sometimes',
                ]
            );
            $services = Services::where('category_id', $validateData['category'])->where('status', 1)->orderBy('price', 'asc')->get();
            if (!$services) throw new \ErrorException('Kategori ini tidak memiliki layanan yang aktif');
            $newDataServices = array();
            foreach ($services as $service) {
                array_push($newDataServices, [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => rupiah($service->price),
                    'description' => $service->description,
                    'image' => $service->image,
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengambil Data Layanan',
                'data' => $newDataServices
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function priceSosmed(Request $request)
    {
        try {
            $validateData = $this->validate(
                $request,
                [
                    'service' => 'required|sometimes',
                ]
            );
            $service = Services::select('price', 'description', 'min', 'max', 'name', 'type', 'is_canceled', 'is_refill', 'id')->where('id', $validateData['service'])->first();
            $model = OrdersSosmed::query()->select(DB::raw('AVG(TIME_TO_SEC(TIMEDIFF( updated_at, created_at ))) AS timediff,service_name,quantity'))->where('service_name', $service->name)->groupBy('service_name')->first();
            if (!$service) throw new \ErrorException('Layanan tidak ditemukan / Layanan sedang tidak aktif');
            $service['price'] = rupiah($service['price']);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $service,
                'average' => !$model ? 'Data tidak ditemukan' : CarbonInterval::seconds((int) $model->timediff)->cascade()->forHumans()
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function TotalPriceSosmed(Request $request)
    {
        try {
            $validateData = $this->validate(
                $request,
                [
                    'services' => 'required|sometimes',
                    'quantity' => 'required|sometimes',
                ]
            );
            $service = Services::select('price', 'description', 'min', 'max', 'name')->where('id', $validateData['services'])->first();
            $ecer = $service['price'] / 1000;
            $total = $ecer * $validateData['quantity'];
            $service['price'] = rupiah($service['price']);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'total' => $total
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'lineError' => $e->getLine()
            ]);
        }
    }
    public function favGetServices(Request $request)
    {
        try {
            $validateData = $this->validate(
                $request,
                [
                    'category' => 'required|sometimes',
                ]
            );
            $favServices = FavoriteServices::where('category_id', $validateData['category'])->orderBy('service_id', 'asc')->get();
            if (!$favServices) throw new \ErrorException('Kategori ini tidak memiliki layanan yang aktif');
            $newDataServices = array();
            foreach ($favServices as $fav) {
                $service = Services::where('id', $fav['service_id'])->first();
                array_push($newDataServices, [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => rupiah($service->price),
                    'description' => $service->description,
                    'image' => $service->image,
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengambil Data Layanan',
                'data' => $newDataServices
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function orderSosmed(Request $request)
    {
        try {
            DB::beginTransaction();
            $array = array();
            $user = Auth::user();
            $dUser = User::where('id', $user->id)->first();
            $balance = $dUser->balance - get_config('saldo_minimal');
            $validateData = $this->validate(
                $request,
                [
                    'service' => 'required',
                    'quantity' => 'required',
                    'target' => 'required',
                ],
                [
                    'service.required' => 'Anda belum memilih layanan',
                    'quantity.required' => 'Anda belum memasukan jumlah pemesanan',
                    'target' => 'Anda belum memasukan target pemesanan'
                ]
            );

            $service = Services::where('id', $validateData['service'])->where('status', 1)->first();
            if (!$service) {
                throw new \ErrorException('Layanan tidak ditemukan');
            } else {
                $provider = Providers::where('id', $service['provider'])->first();
                if (!$provider) {
                    throw new \ErrorException('Layanan sedang dalam perbaikan');
                }
                $role = Role::where('id', $dUser->role_id)->first();
                $persen = $role['total_discount'] / 100;
                $priceServices = $service['price'] - ($service['price'] * $persen);
                if ($request->type == "cc") {
                    $quantity = count(explode(PHP_EOL, $request->custom_comments));
                    $mmekdusu = str_replace("\r\n", '\r\n', $request->custom_comments);
                    $price = ($priceServices / 1000) * $quantity;
                } else {
                    $quantity = $validateData['quantity'];
                    $price = ($priceServices / 1000) * $quantity;
                }
                $take_profit = $role['take_profit'] / 100;
                $profit = ($service['profit'] / 1000) * $quantity;
                if ($request->type == "cc" and empty($request->custom_comments)) {
                    throw new \ErrorException('Kolom Custom Comments Harus Diisi');
                } else if ($request->type == "cl" and empty($request->username)) {
                    throw new \ErrorException('Kolom Username Target Harus Diisi');
                } else {
                    if ($quantity < $service['min']) {
                        throw new \ErrorException('Pesanan anda lebih kecil dari minimal order sebesar ' . $service['min'] . '');
                    } else if ($quantity > $service['max']) {
                        throw new \ErrorException('Pesanan anda lebih besar dari maksimal order sebesar ' . $service['max'] . '');
                    } else if ($balance < $price) {
                        throw new \ErrorException('Saldo anda tidak mencukupi untuk melakukan order ini');
                    } else if ($service['status'] == 0) {
                        throw new \ErrorException('Layanan sedang tidak tersedia');
                    } else {
                        $result_api = false;
                        if (empty($provider)) {
                            $result_api = true;
                        } else {
                            $result_message = "";
                            if ($provider->type == "LUAR" || $provider->type == "UNDRCTRL") {
                                if ($request['type'] == "cc") {
                                    $data = array(
                                        'key' => $provider['api_key'],
                                        'action' => 'add',
                                        'service' => $service->service_id,
                                        'comments' => $request->custom_comments,
                                        'link' => $request['target']
                                    );
                                } else  if ($request['type'] == "cl") {
                                    $data = array(
                                        'key' => $provider['api_key'],
                                        'action' => 'add',
                                        'service' => $service->service_id,
                                        'username' => $request->username,
                                        'quantity' =>  $quantity,
                                        'link' => $request['target']
                                    );
                                } else {
                                    $data = array(
                                        'key' => $provider['api_key'],
                                        'action' => 'add',
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'link' => $request['target']
                                    );
                                }
                            } else if ($provider->type == "INDO") {
                                if ($request['type'] == "cc") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'api_id' => $provider['api_id'],
                                        'service' => $service->service_id,
                                        'custom_comments' =>  $request->custom_comments,
                                        'target' => $request['target']
                                    );
                                } else  if ($request['type'] == "cl") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'api_id' => $provider['api_id'],
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'target' => $request['target'],
                                        'custom_link' => $request->username
                                    );
                                } else {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'api_id' => $provider['api_id'],
                                        'service' => $service->service_id,
                                        'quantity' => $quantity,
                                        'target' => $request['target']
                                    );
                                }
                            } else if ($provider->type ==  "INDO OLD") {
                                if ($request['type'] == "cc") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'custom_comments' => $request->custom_comments,
                                        'data' => $request['target']
                                    );
                                } else  if ($request['type'] == "cl") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'data' => $request['target'],
                                        'custom_link' => $request->username
                                    );
                                } else {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'data' => $request['target']
                                    );
                                }
                            } else if ($provider->type ==  "BuzzerPanel") {
                                if ($request['type'] == "cc") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'secret_key' => $provider['api_id'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'custom_comments' => $request->custom_comments,
                                        'data' => $request['target']
                                    );
                                } else  if ($request['type'] == "cl") {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'secret_key' => $provider['api_id'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'data' => $request['target'],
                                        'custom_link' => $request->username
                                    );
                                } else {
                                    $data = array(
                                        'api_key' => $provider['api_key'],
                                        'secret_key' => $provider['api_id'],
                                        'action' => 'order',
                                        'service' => $service->service_id,
                                        'quantity' =>  $quantity,
                                        'data' => $request['target']
                                    );
                                }
                            } else {
                                $result_api = true;
                                $orders_id = '1';
                                $curl = array(
                                    'type' => 'Manual'
                                );
                            }
                            if ($provider['type'] !== "Manual") {
                                $url = $provider->api_url_order;
                                $curl = post_curl($url, $data);
                                $result_api = false;
                                if (
                                    $provider->type == "LUAR" and isset($curl['error']) ||
                                    $provider->type == "UNDRCTRL" and isset($curl['error']) ||
                                    $provider->type == "LUAR" and !isset($curl['order']) ||
                                    $provider->type == "UNDRCTRL" and !isset($curl['order'])
                                ) {
                                    $result_api = false;
                                    Log::channel('provider')->error('[PROVIDER ORDER LUAR] ' . json_encode($curl));
                                } else {
                                    if ($provider->type == "LUAR" || $provider->type == "UNDRCTRL") {
                                        $result_api = true;
                                        $orders_id = $curl['order'];
                                    } else {
                                        if ($provider->type == "INDO" || $provider->type == "INDO OLD" || $provider->type == "BuzzerPanel") {
                                            if ($curl['status'] == false || empty($curl)) {
                                                Log::channel('provider')->info('[PROVIDER ORDER INDO] ' . json_encode($curl));
                                                $result_api = false;
                                            } else {
                                                $result_api = true;
                                                $orders_id = $curl['data']['id'];
                                            }
                                        }
                                    }
                                }
                            }
                            if ($result_api == false) {
                                Log::channel('provider')->info('[GAGAL ORDER] KARENA :' . json_encode($curl));
                                Log::channel('provider')->info('[PROVIDER] ' . $provider->name);
                                Log::channel('provider')->info('[POST DATA] ' . json_encode($data));
                                Log::channel('provider')->info('[URL] ' . $provider->api_url_order);
                                throw new \ErrorException('Tidak dapat mengirimkan order ke server');
                            } else {
                                $dInsert = [
                                    'order_id' => $orders_id,
                                    'user_id' => $user['id'],
                                    'service_id' => $service->id,
                                    'service_name' => $service->name,
                                    'target' => $validateData['target'],
                                    'quantity' => $quantity,
                                    'price' => $price,
                                    'profit' => $profit,
                                    'comments' => isset($mmekdusu) ? $mmekdusu : '',
                                    'link' => isset($request->username) ? $request->username : '',
                                    'start_count' => 0,
                                    'remains' => 0,
                                    'date' => date('d-m-Y'),
                                    'from' => 'web',
                                    'provider' => $provider->id,
                                    'status' => 'Pending',
                                    'logs_order' => json_encode($curl, TRUE),
                                    'is_canceled' => $service['is_canceled'],
                                    'is_refill' => $service['is_refill'],
                                    'refund' => 0
                                ];
                                $insert = OrdersSosmed::create($dInsert);
                                if (!$insert)  throw new \ErrorException('Gagal Membuat Pesanan');
                                Activity::create([
                                    'user_id' => $user['id'],
                                    'amount' => $price,
                                    'type' => 'minus',
                                    'note' => 'Melakukan Pembelian Layanan ' . $service->name . ' Via Web dengan Nomor Order ' . $insert->id . '',
                                ]);
                                $dUser['balance'] = $dUser['balance'] - $price;
                                $dUser->save();
                            }
                        }
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Pesanan anda berhasil dikirim, silahkan cek status pesanan anda di menu Pesanan',
            ]);
        } catch (\ErrorException $e) {
            Log::channel('error')->info("Pesan : {$e->getMessage()} <br/> File: {$e->getFile()}<br/>Line: {$e->getLine()}");
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, Silahkan Hubungi Admin'
            ]);
        }
    }
    public function doDeposit(Request $request)
    {
        $user = Auth::user();
        try {
            $validateData = $this->validate(
                $request,
                [
                    'amount' => 'required',
                    'method' => 'required',
                    'gateway' => 'required',
                ],
                [
                    'amount.required' => 'Jumlah Deposit Wajib Diisi',
                    'method.required' => 'Metode Pembayaran Wajib Diisi',
                    'gateway.required' => 'Metode Pembayaran Wajib Diisi',
                ]
            );

            if ($validateData['amount'] < get_config('deposit_minimal')) {
                throw new \ErrorException('Deposit Minimal ' . rupiah(get_config('deposit_minimal')));
            } else {
                if ($validateData['gateway'] !== "tripay") {
                    $method = Method::where('name', 'LIKE', '%' . $validateData['method'] . '%')->first();
                    if (is_null($method)) {
                        throw new \ErrorException('Metode tidak ditemukan');
                    } else if (get_config('deposit_minimal') > $validateData['amount']) {
                        throw new \ErrorException('Deposit Minimal ' . rupiah(get_config('deposit_minimal')));
                    } else if ($method->min > $validateData['amount']) {
                        throw new \ErrorException('Deposit Minimal ' . rupiah(get_config('deposit_minimal')));
                    }
                    $deposit_ref = null;
                    $qr_code = null;
                    $name = $method->name;
                    $note = "<span>" . nl2br($method->note) . "</span>";
                    $amount = $validateData['amount'];
                    $acak = rand(1, 100);
                    $getAmount = $amount * $method['rate'];
                    $benefit = benefit_role($user->role_id);
                    $persen = ($benefit['bonus_deposit'] + $method->bonus) / 100;
                    $finalAmount = $getAmount;
                    $finalGetAmount = $getAmount + ($getAmount * $persen);
                    $validateData['amount'] = $finalAmount + $acak;
                    $validateData['user_id'] = $user['id'];
                    $validateData['method'] = $method['name'];
                    $validateData['method_ref'] = $deposit_ref;
                    $validateData['get'] = $finalGetAmount + $acak;
                    $validateData['fee'] = $acak;
                    $validateData['note'] = htmlspecialchars($note);
                    $validateData['status'] = 'Pending';
                    $validateData['qr_url'] = $qr_code;
                    $data = Deposit::create($validateData);
                    if (!$data) throw new \ErrorException('Terjadi Kesalahan Saat Pembuatan Invoice Deposit');
                    $message = 'Deposit Berhasil dibuat<br/>Lanjut Ke Detail Invoice ?';
                    $id = $data->id;
                } else {
                    $tripayLib = new LibraryTripay();
                    $method = Tripay::where('name', 'LIKE', '%' . $validateData['method'] . '%')->first();
                    $cekBiaya = $tripayLib->calculatorFee($method['code'], $validateData['amount']);
                    if (!$cekBiaya['success']) throw new \ErrorException('Gagal Menghubungkan ke server bank');
                    $name = $method->name;
                    $getAmount = $validateData['amount'] - $cekBiaya['data'][0]['total_fee']['merchant'];
                    $benefit = benefit_role($user->role_id);
                    $persen = ($benefit['bonus_deposit'] + (int) get_config('bonus_payment_gateway')) / 100;
                    $finalAmount = $getAmount;
                    $finalGetAmount = $getAmount + ($getAmount * $persen);
                    $deposit_ref = "DEPO-" . time();
                    $payload = [
                        'method'            => $method['code'], // IMPORTANT, dont fill by `getMethod()`!, for more code method you can check here https://tripay.co.id/developer
                        'merchant_ref'      => $deposit_ref,
                        'amount'            => $validateData['amount'],
                    ]; // set your payload, with more examples https://tripay.co.id/developer
                    $dataTripay = $tripayLib->createCreatePayment($payload);
                    if (!$dataTripay['success']) {
                        throw new \ErrorException('Gagal Menghubungi Pihak Bank');
                    } else {
                        $name = $dataTripay['data']['payment_name'];
                        $dataArray = $dataTripay['data'];
                        $getAmount = $dataArray['amount_received'];
                        $instruction = $dataArray['instructions'];
                        $qr_code = isset($dataArray['qr_url']) ? $dataArray['qr_url'] : null;
                        $note = '';
                        foreach ($instruction as $i) {
                            $note .= "<b>" . $i['title'] . '</b>';
                            foreach ($i['steps'] as $key => $value) {
                                $note .= '<li>' . $i['steps'][$key] . '</li>';
                            }
                        }
                        $validateData['amount'] = $getAmount;
                        $validateData['user_id'] = $user['id'];
                        $validateData['method'] = $name;
                        $validateData['method_ref'] = $deposit_ref;
                        $validateData['get'] = $finalGetAmount;
                        $validateData['fee'] = $cekBiaya['data'][0]['total_fee']['merchant'];
                        $validateData['note'] = htmlspecialchars($note);
                        $validateData['status'] = 'Pending';
                        $validateData['qr_url'] = $qr_code;
                        $validateData['url_payment'] = ($dataArray['payment_method'] == "SHOPEEPAY") ? $dataArray['pay_url'] : $dataArray['checkout_url'];
                        $data = Deposit::create($validateData);
                        if (!$data) throw new \ErrorException('Terjadi Kesalahan Saat Pembuatan Invoice Deposit');
                        $message = 'Deposit Berhasil dibuat<br/>Lanjut Ke Detail Invoice ?';
                        $id = $data->id;
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => $message,
                'id' => $id
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'getLine' => $e->getLine()
            ]);
        }
    }
    public function generateApiKey(Request $request)
    {
        $user = Auth::user();

        $dUser = User::find($user->id);
        $dUser->api_key = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));
        $dUser->save();
    }

    public function tickets(Request $request)
    {
        try {
            $user = Auth::user();
            if ($request->status == "add") {
                $validateData = $this->validate(
                    $request,
                    [
                        'message' => 'required',
                        'type' => 'required',
                        'orderId' => 'sometimes',
                    ],
                    [
                        'message.required' => 'Message Harus Diisi',
                        'type.required' => 'Type Harus Diisi',
                    ]
                );
                $insert = Tickets::create([
                    'user_id' => $user->id,
                    'message' => $validateData['message'],
                    'type' => $validateData['type'],
                    'order_id' => $validateData['orderId']
                ]);
                TicketReply::create([
                    'ticket_id' => $insert->id,
                    'user_id' => $user->id,
                    'message' => $validateData['message'],
                ]);
                if (!$insert) throw new \ErrorException('Gagal Membuat Ticket');
                $message = "Berhasil Membuat Ticket";
            } else if ($request->status == "reply") {
                $validateData = $this->validate($request, [
                    'message' => 'required',
                ], [
                    'message.required' => 'Message Harus Diisi',
                ]);
                $cek_ticket = Tickets::where('id', $request->ticket_id)->first();
                $updateTicket = array(
                    'seen' => 1,
                    'is_reply' => 0,
                );

                Tickets::where('id', $cek_ticket->id)->update($updateTicket);
                $insert = TicketReply::create([
                    'ticket_id' => $request->ticket_id,
                    'user_id' => $user->id,
                    'message' => $validateData['message'],
                ]);
                if (!$insert) throw new \ErrorException('Gagal Balas Ticket');
                $message = "Berhasil Balas Ticket";
            } else if ($request->status == "close") {
                $update = Tickets::where('id', $request['id'])->update([
                    'status' => "Closed"
                ]);
                if (!$update) throw new \ErrorException('Gagal Close Ticket');
                $message = "Berhasil Close Ticket";
            } else {
                throw new \ErrorException('Unknown Action');
            }
            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'getLine' => $e->getLine()
            ]);
        }
    }
    public function userSetting(Request $request)
    {
        try {
            $validateData = $this->validate($request, [
                'name' => 'required',
                'current_password' => 'required',
            ], [
                'name.required' => 'Nama Harus Diisi',
                'current_password.required' => 'Password Harus Diisi',
            ]);
            $user = Auth::user();
            $duser = User::where('id', $user->id)->first();
            $update = [];
            if (is_null($request->password)) {
                if (Hash::check($validateData['current_password'], $duser['password'])) throw new \ErrorException('Password tidak sesuai');
                $update['name'] =  $validateData['name'];
            } else {
                $newvalidateData =  $this->validate($request, [
                    'password' => 'required|confirmed',
                ], [
                    'password.required' => 'Password Harus Diisi',
                    'password.confirmed' => 'Password Tidak Sama',
                ]);
                if (Hash::check($validateData['current_password'], $duser['password'])) throw new \ErrorException('Password tidak sesuai');
                $update['password'] = Hash::make($newvalidateData['password']);
            }
            $updateUser = User::where('id', $user->id)->update($update);
            if (!$updateUser) throw new \ErrorException('Tidak dapat memperbaharui Data akun anda');
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Memperbaharui Data Akun Anda',
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'getLine' => $e->getLine()
            ]);
        }
    }
    public function detailOrderSocial($id)
    {
        return OrdersSosmed::find($id);
    }
    public function changeOrders(Request $request)
    {
        $user = Auth::user();
        try {
            $validate = $this->validate($request, [
                'action' => 'required|in:cancel,refill',
                'id' => 'required'
            ], [
                'action.required' => 'Aksi tidak ditemukan',
                'action.in' => 'Aksi Hanya tersedia Cancel / Refill',
                'id.required' => 'ID order tidak valid'
            ]);
            if ($validate['action'] == "cancel") {
                $order = OrdersSosmed::where('id', $validate['id'])->first();
                $service = Services::where('id', $order['service_id'])->first();
                if (empty($order)) throw new \ErrorException('Pesanan tidak ditemukan');
                if (empty($service)) throw new \ErrorException('Layanan tidak ditemukan / Sedang tidak aktif');
                if (!$service['is_canceled']) throw new \ErrorException('Layanan tidak dapat DiCancel');
                $dInsert = [
                    'order_id' => $order['id'],
                    'provider_order_id' => $order['order_id'],
                    'user_id' => $user->id,
                    'type' => 'Cancel',
                    'status' => 'Pending',
                    'provider_id' => $order['provider'],
                    'log_process' => 'Manual by Action'
                ];
                $insert = OrderRequest::create($dInsert);
                if (!$insert) throw new \ErrorException('Tidak Berhasil Melakukan Request Cancel Pemesanan');
                $message = 'Berhasil Melakukan Request Cancel Pemesanan';
            } else if ($validate['action'] == "refill") {
                $order = OrdersSosmed::where('id', $validate['id'])->first();
                $service = Services::where('id', $order['service_id'])->first();
                $provider = Providers::where('id', $order['provider'])->first();
                if (empty($order)) throw new \ErrorException('Pesanan tidak ditemukan');
                if (empty($service)) throw new \ErrorException('Layanan tidak ditemukan / Sedang tidak aktif');
                if (empty($provider)) throw new \ErrorException('Layanan tidak Support Fitur ini');
                if (!$service['is_refill']) throw new \ErrorException('Layanan tidak dapat DiRefill');
                if ($provider['type'] == "LUAR") {
                    $data = array(
                        'key' => $provider['api_key'],
                        'action' => 'refill',
                        'orders' => $order['order_id'],
                    );
                } else if ($provider['type'] == "INDO") {
                    $data = array(
                        'api_key' => $provider['api_key'],
                        'api_id' => $provider['api_id'],
                        'id_order' => $order['order_id'],
                    );
                } else {
                    throw new \ErrorException('Layanan tidak Support Refill');
                }
                $url = $provider['api_url_refill'];
                $curl = post_curl($url, $data);
                $result_api = false;
                if (
                    $provider['type'] == "LUAR" and !isset($curl['refill'])
                ) {
                    $result_api = false;
                    Log::channel('provider')->error('[PROVIDER REFILL LUAR] ' . json_encode($curl));
                } else {
                    if ($provider->type == "LUAR") {
                        $result_api = true;
                        $result = $curl['refill'];
                    } else {
                        if ($provider->type == "INDO") {
                            if ($curl['status'] == false || empty($curl)) {
                                Log::channel('provider')->info('[PROVIDER REFILL INDO] ' . json_encode($curl));
                                $result_api = false;
                            } else {
                                $result_api = true;
                                $result = $curl['data']['id_refill'];
                            }
                        }
                    }
                }
                if ($result_api) {
                    $dInsert = [
                        'order_id' => $order['id'],
                        'provider_order_id' => $order['order_id'],
                        'provider_request_id' => $result,
                        'user_id' => $user->id,
                        'type' => 'Refill',
                        'status' => 'Pending',
                        'provider_id' => $order['provider'],
                        'log_process' => json_encode($curl, TRUE)
                    ];
                    $insert = OrderRequest::create($dInsert);
                    if (!$insert) throw new \ErrorException('Tidak Berhasil Melakukan Request Cancel Pemesanan');
                    $message = 'Berhasil Melakukan Request Cancel Pemesanan';
                } else {
                    throw new \ErrorException('Gagal Melakukan Request Refill');
                }
            }
            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'getLine' => $e->getLine()
            ]);
        }
    }
}
