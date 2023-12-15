<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\OrdersSosmed;
use App\Models\Providers;
use App\Models\Role;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    public function getDataServices(Request $request)
    {
        $apiId = $request->api_id;
        $apiKey = $request->api_key;
        if ($apiId && $apiKey) {
            $user = User::where('id', $apiId)->where('api_key', $apiKey)->first();
            $role = Role::where('id', $user->role_id)->first();
            if ($user) {
                if (isset($request->category_id)) {
                    $data = Services::select('services.id as id', 'categories.name as category', 'services.name as name', 'services.description as description', 'services.price as price', 'services.min as min', 'services.max as max', 'services.type as type', 'services.status as status')->join('categories', 'services.category_id', '=', 'categories.id')->where([['services.category_id', '=', $request->category_id], ['services.status', '!=', 3]])->orderBy('price', 'asc')->get();
                } else {
                    $data = Services::select('services.id as id', 'categories.name as category', 'services.name as name', 'services.description as description', 'services.price as price', 'services.min as min', 'services.max as max', 'services.type as type', 'services.status as status')->join('categories', 'services.category_id', '=', 'categories.id')->where([['services.status', '!=', 3]])->orderBy('price', 'asc')->get();
                }
                return response()->json(['message' => 'Success Get Data Services', 'status' => true, 'data' => $data]);
            } else {
                return response()->json(['message' => 'Credential not matched!', 'status' => false]);
            }
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => false]);
        }
    }
    public function getProfile(Request $request)
    {
        $apiId = $request->api_id;
        $apiKey = $request->api_key;
        if ($apiId && $apiKey) {
            $user = User::where('id', $apiId)->where('api_key', $apiKey)->first();
            if ($user) {
                $data = User::select('id', 'name', 'email', 'balance')->where('id', $user->id)->get();
                if ($data) {
                    return response()->json(['message' => 'Success Get Data Profile', 'status' => true, 'data' => $data]);
                } else {
                    return response()->json(['message' => 'Error get data', 'status' => false,]);
                }
            } else {
                return response()->json(['message' => 'Credential not matched!', 'status' => false]);
            }
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => false]);
        }
    }

    public function getStatusSocial(Request $request)
    {
        $order_id = $request->order_id;
        $apiId = $request->api_id;
        $apiKey = $request->api_key;
        if ($apiId && $apiKey) {
            $user = User::where('id', $apiId)->where('api_key', $apiKey)->first();
            if ($user) {
                if ($order_id) {
                    $dataOrder = OrdersSosmed::select('id', 'service_name', 'price', 'start_count', 'remains', 'status')->where('id', $order_id)->first();
                    if ($dataOrder) {
                        return response()->json(['message' => 'Success Get Data Order', 'status' => true, 'data' => $dataOrder]);
                    } else {
                        return response()->json(['message' => 'Error get data', 'status' => false,]);
                    }
                } else {
                    return response()->json(['message' => 'Order Id not match!', 'status' => false,]);
                }
            } else {
                return response()->json(['message' => 'Credential not matched!', 'status' => false]);
            }
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => false]);
        }
    }

    public function orderSosmed(Request $request)
    {
        try {
            DB::beginTransaction();
            $array = array();
            $apiId = $request->api_id;
            $apiKey = $request->api_key;
            if ($apiId && $apiKey) {
                $user = User::where('id', $apiId)->where('api_key', $apiKey)->first();
                $role = Role::where('id', $user->role_id)->first();
                if ($user) {
                    if (is_null($request->service)) {
                        throw new \ErrorException('Services cannot be empty!');
                    }
                    if (is_null($request->target)) {
                        throw new \ErrorException('Target cannot be empty!');
                    }
                    $validateData = $this->validate(
                        $request,
                        [
                            'service' => 'required|sometimes',
                            'target' => 'required|sometimes',
                        ],
                    );

                    $service = Services::where('id', $validateData['service'])->where('status', 1)->first();
                    if (!$service) {
                        throw new \ErrorException('Failed to get service or service not active');
                    } else {
                        $provider = Providers::where('id', $service['provider'])->first();
                        if (!$provider) {
                            throw new \ErrorException('Failed to get service or service not active');
                        }
                        if ($service->type == "Custom Comments") {
                            if (is_null($request->custom_comments)) {
                                throw new \ErrorException('Comments cannot be empty!');
                            }
                            $quantity = count(explode(PHP_EOL, $request->custom_comments));
                            $mmekdusu = str_replace("\r\n", '\r\n', $request->custom_comments);
                            $persen = $role['total_discount'] / 100;
                            $priceServices = $service['price'] - ($service['price'] * $persen);
                            $price = round(($priceServices / 1000) * $quantity);
                        } else {
                            if (is_null($request->quantity)) {
                                throw new \ErrorException('Quantity cannot be empty!');
                            }
                            $quantity = $request->quantity;
                            $persen = $role['total_discount'] / 100;
                            $priceServices = $service['price'] - ($service['price'] * $persen);
                            $price = round(($priceServices / 1000) * $quantity);
                        }
                        $provider_cost = ($service['provider_price'] / 1000) * $quantity;
                        $take_profit = $role['take_profit'] / 100;
                        $profit = ($service['price'] / 1000) * $quantity;
                        if ($service->type == "Custom Comments" and empty($request->custom_comments)) {
                            throw new \ErrorException('Comments cannot be empty!');
                        } else if ($service->type == 'Custom Likes' and empty($request->username)) {
                            throw new \ErrorException('Username cannot be empty!');
                        } else {
                            if ($quantity < $service['min']) {
                                throw new \ErrorException('Your Quantity is too low, Mininum Quantity is : ' . $service['min']);
                            } else if ($quantity > $service['max']) {
                                throw new \ErrorException('Your Quantity is too high, Maximum Quntity is : ' . $service['max']);
                            } else if ($user['balance'] < $price) {
                                throw new \ErrorException('Your Balance is too low to order this service, Please top up your balance!');
                            } else if ($service['status'] == 0) {
                                throw new \ErrorException('Failed to get service or service not active');
                            } else {
                                $result_api = false;
                                if (empty($provider)) {
                                    $result_api = true;
                                } else {
                                    $result_message = "";
                                    if ($provider->type == "LUAR") {
                                        if ($service->type == "Custom Comments") {
                                            $data = array(
                                                'key' => $provider['api_key'],
                                                'action' => 'add',
                                                'service' => $service->service_id,
                                                'comments' => $request->custom_comments,
                                                'link' => $request['target']
                                            );
                                        } else  if ($service->type == "Custom Likes") {
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
                                    } else if ($provider->name ==  "BosPedia") {
                                        if ($service->type == "Custom Comments") {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'api_id' => $provider['api_id'],
                                                'service' => $service->service_id,
                                                'comments' => $request->custom_comments,
                                                'target' => $request['target']
                                            );
                                        } else  if ($service->type == "Custom Likes") {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'api_id' => $provider['api_id'],
                                                'service' => $service->service_id,
                                                'quantity' =>  $quantity,
                                                'target' => $request['target'],
                                                'username' => $request->username
                                            );
                                        } else {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'api_id' => $provider['api_id'],
                                                'service' => $service->service_id,
                                                'quantity' =>  $quantity,
                                                'target' => $request['target']
                                            );
                                        }
                                    } else if ($provider->type ==  "INDO") {
                                        if ($service->type == "Custom Comments") {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'api_id' => $provider['api_id'],
                                                'service' => $service->service_id,
                                                'custom_comments' => $request->custom_comments,
                                                'target' => $request['target']
                                            );
                                        } else  if ($service->type == "Custom Likes") {
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
                                                'quantity' =>  $quantity,
                                                'target' => $request['target']
                                            );
                                        }
                                    } else if ($provider->type ==  "INDO OLD") {
                                        if ($service->type == "Custom Comments") {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'action' => 'order',
                                                'service' => $service->service_id,
                                                'custom_comments' => $request->custom_comments,
                                                'data' => $request['target']
                                            );
                                        } else  if ($service->type == "Custom Likes") {
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
                                        if ($service->type == "Custom Comments") {
                                            $data = array(
                                                'api_key' => $provider['api_key'],
                                                'secret_key' => $provider['api_id'],
                                                'action' => 'order',
                                                'service' => $service->service_id,
                                                'custom_comments' => $request->custom_comments,
                                                'data' => $request['target']
                                            );
                                        } else  if ($service->type == "Custom Likes") {
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
                                    }
                                    $url = $provider->api_url_order;
                                    $curl = post_curl($url, $data);
                                    $result_api = false;
                                    if ($provider->type == "LUAR" and isset($curl['error'])) {
                                        $result_api = false;
                                        Log::channel('provider-order')->error('[PROVIDER ORDER LUAR] ' . json_encode($curl));
                                    } else {
                                        if ($provider->type == "LUAR") {
                                            $result_api = true;
                                            $orders_id = $curl['order'];
                                        } else {
                                            if ($provider->type == "INDO" || $provider->type == "INDO OLD" || $provider->type == "BuzzerPanel") {
                                                if (empty($curl) || $curl['status'] == false) {
                                                    Log::channel('provider-order')->info('[PROVIDER ORDER INDO] ' . json_encode($curl));
                                                    $result_api = false;
                                                } else {
                                                    $result_api = true;
                                                    $orders_id = $curl['data']['id'];
                                                }
                                            }
                                        }
                                    }
                                    if ($result_api == false) {
                                        Log::channel('provider-order')->info('[GAGAL ORDER] KARENA :' . json_encode($curl));
                                        Log::channel('provider-order')->info('[PROVIDER] ' . $provider->name);
                                        Log::channel('provider-order')->info('[POST DATA] ' . json_encode($data));
                                        Log::channel('provider-order')->info('[URL] ' . $provider->api_url_order);
                                        throw new \ErrorException('Failed to Connecting to Server');
                                    } else {
                                        $dInsert = [
                                            'order_id' => $orders_id,
                                            'user_id' => $user['id'],
                                            'service_id' => $service->id,
                                            'service_name' => $service->name,
                                            'target' => $validateData['target'],
                                            'quantity' => $quantity,
                                            'price' => $price,
                                            'provider_price' => $provider_cost,
                                            'profit' => $profit,
                                            'comments' => isset($mmekdusu) ? $mmekdusu : '',
                                            'link' => isset($request->username) ? $request->username : '',
                                            'start_count' => 0,
                                            'remains' => 0,
                                            'date' => date('d-m-Y'),
                                            'from' => 'api',
                                            'provider' => $provider->id,
                                            'status' => 'Pending',
                                            'logs_order' => json_encode($curl, TRUE),
                                            'refund' => 0
                                        ];
                                        $insert = OrdersSosmed::create($dInsert);
                                        if ($insert) {
                                            Activity::create([
                                                'user_id' => $user['id'],
                                                'amount' => $price,
                                                'type' => 'minus',
                                                'note' => 'Melakukan Pembelian Layanan ' . $service->name . ' Via API dengan Nomor Order ' . $insert->id . '',
                                            ]);
                                            $user['balance'] = $user['balance'] - $price;
                                            $user->save();
                                            DB::commit();
                                            return response()->json([
                                                'status' => true,
                                                'message' => 'Success to Order',
                                                'data' => array(
                                                    'order_id' => $insert->id,
                                                    'service_name' => $service->name,
                                                    'quantity' => $quantity,
                                                    'price' => $price,
                                                )
                                            ]);
                                            Log::channel('API-ORDER')->info('BERHASIL');
                                        } else {
                                            Log::channel('API-ORDER')->info('GAGAL INSERT');
                                            throw new \ErrorException('Failed to Order. Please Contact Administrator');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return $array;
                } else {
                    return response()->json(['message' => 'Credential not matched!', 'status' => false]);
                }
            } else {
                return response()->json(['message' => 'Unauthorized', 'status' => false]);
            }
        } catch (\Exception $e) {
            Log::channel('API-ORDER')->info($e->getMessage());
            DB::rollback();
            /* Transaction failed. */
            return response()->json(['message' => $e->getMessage(), 'status' => false]);
        }
    }
}
