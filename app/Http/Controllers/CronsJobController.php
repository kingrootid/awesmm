<?php

namespace App\Http\Controllers;

use App\Library\Tripay;
use App\Models\Activity;
use App\Models\ActivityServices;
use App\Models\OrdersSosmed;
use App\Models\Providers;
use App\Models\Services;
use App\Models\Tripay as ModelsTripay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CronsJobController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
    }
    public function getPaymentChannel()
    {
        $tripay = new Tripay();
        try {
            $data = $tripay->getPaymentChannel();
            if ($data['success']) {
                ModelsTripay::truncate();
                foreach ($data['data'] as $payment) {
                    $images = file_get_contents($payment['icon_url']);
                    file_put_contents(public_path() . '/icon/' . $payment['name'] . '.png', $images);
                    $dataInsert = [
                        'name' => $payment['name'],
                        'code' => $payment['code'],
                        'group' => $payment['group'],
                        'fee_flat' => $payment['total_fee']['flat'],
                        'images' => $payment['name'] . '.png',
                        'fee_percent' => $payment['total_fee']['percent'],
                        'status' => $payment['active'] ? "ACTIVE" : "INACTIVE",
                    ];
                    $insert = ModelsTripay::create($dataInsert);
                    if ($insert) {
                        echo "Inserted: " . $payment['name'] . "<br/>";
                    } else {
                        echo "Failed: " . $payment['name'] . "<br/>";
                    }
                }
            } else {
                echo 'Gagal Mengambil Data <br/>';
                echo 'error karena ' . json_encode($data, true);
            }
        } catch (\ErrorException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function getServicesSosmed($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where('name', $name)->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else if ($providerData->type == "LUAR" || $providerData->type == "INDO OLD" || $providerData->type == "Manual" || $providerData->type == "BuzzerPanel") {
                echo 'Provider not supported';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('api_id' => $providerData->api_id, 'api_key' => $providerData->api_key);
                $getServices = post_curl($urlServices, $data_post);
                if ($getServices['status'] == true) {
                    foreach ($getServices['data'] as $dServices) {
                        if (get_config('provider_markup') == "persen") {
                            $persen = $providerData->markup / 100;
                            $price = $dServices['price'] + ($dServices['price'] * $persen);
                        } else {
                            $price = $dServices['price'] + $providerData->markup;
                        }

                        $check = Services::where('service_id', $dServices['id'])->where('name', 'not like', 'BPM')->where('provider', $providerData->id)->first();
                        if (empty($check)) {
                            $dInsert = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $dServices['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'description' => !isset($dServices['description']) ? $dServices['note'] : $dServices['description'],
                                'status' => 0,
                            ];
                            $insert = Services::create($dInsert);
                            if ($insert) {
                                echo "Inserted: " . $dServices['name'] . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            } else {
                                echo "Failed: " . $dServices['name'] . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            }
                        } else if ($check) {
                            if ($check->category_id > 0) {
                                if ($check->price < $price) {
                                    $type = "increase";
                                    $diff = $check->price + $price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                } else if ($check->price > $price) {
                                    $type = "decrease";
                                    $diff = $price - $check->price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                }
                            }
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check->name,
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            } else {
                                echo "Failed Update: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            }
                        } else {
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check->name,
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'status' => 0
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update Layanan NonAktif Dari Provider: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            } else {
                                echo "Failed Update Layanan NonAktif Dari Provider: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            }
                        }
                    }
                } else {
                    echo 'Failed to get services';
                }
            }
        }
    }
    public function getServicesSosmedOld($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where('name', $name)->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else if ($providerData->type == "LUAR" || $providerData->type == "INDO" || $providerData->type == "Manual" || $providerData->type == "BuzzerPanel") {
                echo 'Provider not supported';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('api_key' => $providerData->api_key, 'action' => 'services');
                $getServices = post_curl($urlServices, $data_post);
                if ($getServices['status'] == true) {
                    foreach ($getServices['data'] as $dServices) {
                        if (get_config('provider_markup') == "persen") {
                            $persen = $providerData->markup / 100;
                            $price = $dServices['price'] + ($dServices['price'] * $persen);
                        } else {
                            $price = $dServices['price'] + $providerData->markup;
                        }
                        $check = Services::where('service_id', $dServices['id'])->where('name', 'not like', 'BPM')->where('provider', $providerData->id)->first();
                        if (empty($check)) {
                            $dInsert = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $dServices['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'description' => $dServices['note'],
                                'status' => 0,
                            ];
                            $insert = Services::create($dInsert);
                            if ($insert) {
                                echo "Inserted: " . $dServices['name'] . "<br/>";
                            } else {
                                echo "Failed: " . $dServices['name'] . "<br/>";
                            }
                        } else if ($check) {
                            if ($check->category_id > 0) {
                                if ($check->price < $price) {
                                    $type = "increase";
                                    $diff = $check->price + $price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                } else if ($check->price > $price) {
                                    $type = "decrease";
                                    $diff = $price - $check->price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                }
                            }
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update: " . $dServices['name'] . "<br/>";
                            } else {
                                echo "Failed Update: " . $dServices['name'] . "<br/>";
                            }
                        } else {
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'status' => 0
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update Layanan Dari Provider: " . $dServices['name'] . "<br/>";
                            } else {
                                echo "Failed Update Layanan Dari Provider: " . $dServices['name'] . "<br/>";
                            }
                        }
                    }
                } else {
                    echo 'Failed to get services';
                }
            }
        }
    }
    public function getServicesSosmedST($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where('name', $name)->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else if ($providerData->type == "LUAR" || $providerData->type == "INDO OLD" || $providerData->type == "Manual" || $providerData->type == "BuzzerPanel") {
                echo 'Provider not supported';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('api_id' => $providerData->api_id, 'api_key' => $providerData->api_key);
                $getServices = post_curl($urlServices, $data_post);
                if ($getServices['status'] == true) {
                    foreach ($getServices['data'] as $dServices) {
                        if (get_config('provider_markup') == "persen") {
                            $persen = $providerData->markup / 100;
                            $price = $dServices['price'] + ($dServices['price'] * $persen);
                            $profit = $dServices['price'] - ($dServices['price'] * $persen);
                        } else {
                            $price = $dServices['price'] + $providerData->markup;
                            $profit = $dServices['price'] - $providerData->markup;
                        }

                        $check = Services::where('service_id', $dServices['id'])->where('name', 'not like', '%BPM%')->where('provider', $providerData->id)->first();
                        if (empty($check)) {
                            $dInsert = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $dServices['name'],
                                'price' => $price,
                                'provider_price' => $dServices['price'],
                                'profit' => $profit,
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'description' => !isset($dServices['description']) ? $dServices['note'] : $dServices['description'],
                                'status' => $dServices['status'],
                            ];
                            $insert = Services::create($dInsert);
                            if ($insert) {
                                echo "Inserted: " . $dServices['name'] . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            } else {
                                echo "Failed: " . $dServices['name'] . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            }
                        } else if ($check) {
                            if ($check->category_id > 0) {
                                if ($check->price < $price) {
                                    $type = "increase";
                                    $diff = $check->price + $price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                } else if ($check->price > $price) {
                                    $type = "decrease";
                                    $diff = $price - $check->price;
                                    $ActivityServices = ActivityServices::create([
                                        'type' => $type,
                                        'services_id' => $check->id,
                                        'amount' => $diff,
                                        'name' => $check->name,
                                        'services_provider_id' => $providerData->id,
                                        'services_provider_name' => $dServices['name'],
                                    ]);
                                    $cek =  ActivityServices::where('amount', $diff)->where('name', $check->name)->first();
                                    if (empty($cek)) {
                                        if ($ActivityServices) {
                                            echo "Insert Activity : " . $dServices['name'] . "<br/>";
                                        } else {
                                            echo "Failed Activity : " . $dServices['name'] . "<br/>";
                                        }
                                    }
                                }
                            }
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check->name,
                                'price' => $price,
                                'provider_price' => $dServices['price'],
                                'profit' => $profit,
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'status' => $dServices['status'],
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            } else {
                                echo "Failed Update: " . $check->name . " HARGA: " . $price . " ID Layanan : " . $dServices['id'] . "<br/>";
                            }
                        } else {
                        }
                    }
                } else {
                    echo 'Failed to get services';
                }
            }
        }
    }
    public function getServicesSosmedLuar($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where('name', $name)->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else if ($providerData->type == "INDO" || $providerData->type == "INDO OLD" || $providerData->type == "Manual" || $providerData->type == "BuzzerPanel") {
                echo 'Provider not supported';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('key' => $providerData->api_key, 'action' => 'services');
                $getServices = post_curl($urlServices, $data_post);
                $provider_markup = get_config('provider_markup');
                $kurs = get_config('rate_usd');
                foreach ($getServices as $dServices) {
                    $priceKurs = $dServices['rate'] * $kurs;
                    if ($provider_markup == "persen") {
                        $persen = $providerData->markup / 100;
                        $price = $priceKurs + ($priceKurs * $persen);
                    } else {
                        $price = $priceKurs + $providerData->markup;
                    }
                    $check = Services::where('service_id', $dServices['service'])->where('name', 'not like', 'BPM')->where('provider', $providerData->id)->first();
                    if (empty($check)) {
                        $dInsert = [
                            'service_id' => $dServices['service'],
                            'provider' => $providerData->id,
                            'name' => !isset($dServices['name']) ? 'Tidak ada nama' : $dServices['name'],
                            'price' => $price,
                            'profit' => $dServices['rate'],
                            'min' => $dServices['min'],
                            'max' => $dServices['max'],
                            'description' => !isset($dServices['name']) ? 'Tidak ada nama' : $dServices['name'],
                            'status' => 1,
                        ];
                        $insert = Services::create($dInsert);
                        if ($insert) {
                            echo "Inserted: " . !isset($dServices['name']) ? 'Tidak ada nama' : $dServices['name'] .  " HARGA: " . $price . " ID Layanan : " . $dServices['service'] . "<br/>";
                        } else {
                            echo "Failed: " . !isset($dServices['name']) ? 'Tidak ada nama' : $dServices['name'] .  " HARGA: " . $price . " ID Layanan : " . $dServices['service'] . "<br/>";
                        }
                    } else {
                        $dUpdate = [
                            'service_id' => $dServices['service'],
                            'provider' => $providerData->id,
                            'name' => $check->name,
                            'price' => $price,
                            'profit' => $dServices['rate'],
                            'min' => $dServices['min'],
                            'max' => $dServices['max'],
                            'status' => $check['status'],
                        ];
                        $update = Services::where('id', $check->id)->update($dUpdate);
                        if ($update) {
                            echo "Update: " . $check->name .  " HARGA: " . $price . " ID Layanan : " . $dServices['service'] . "<br/>";
                        } else {
                            Log::channel('provider-order')->error('[UPDATE SERVICE ERROR] ' . json_encode($update));
                            echo "Failed Update: " . $check->name . "<br/>";
                        }
                    }
                }
            }
        }
    }
    public function getServicesSosmedBuzzer($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where('name', $name)->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else if ($providerData->type == "LUAR" || $providerData->type == "INDO" || $providerData->type == "Manual" || $providerData->type == "INDO OLD") {
                echo 'Provider not supported';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('api_key' => $providerData->api_key, 'secret_key' => $providerData->api_id, 'action' => 'services');
                $getServices = post_curl($urlServices, $data_post);
                if ($getServices['status'] == true) {
                    foreach ($getServices['data'] as $dServices) {
                        if (get_config('provider_markup') == "persen") {
                            $persen = $providerData->markup / 100;
                            $price = $dServices['price'] + ($dServices['price'] * $persen);
                        } else {
                            $price = $dServices['price'] + $providerData->markup;
                        }

                        $check = Services::where('service_id', $dServices['id'])->where('name', 'not like', 'BPM')->where('provider', $providerData->id)->first();
                        if (empty($check)) {
                            $dInsert = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $dServices['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                                'description' => $dServices['note'],
                                'status' => 0,
                            ];
                            $insert = Services::create($dInsert);
                            if ($insert) {
                                echo "Inserted: " . $dServices['name'] . "<br/>";
                            } else {
                                echo "Failed: " . $dServices['name'] . "<br/>";
                            }
                        } else {
                            $dUpdate = [
                                'service_id' => $dServices['id'],
                                'provider' => $providerData->id,
                                'name' => $check['name'],
                                'price' => $price,
                                'profit' => $dServices['price'],
                                'min' => $dServices['min'],
                                'max' => $dServices['max'],
                            ];
                            $update = Services::where('id', $check->id)->update($dUpdate);
                            if ($update) {
                                echo "Update: " . $dServices['name'] . "<br/>";
                            } else {
                                echo "Failed Update: " . $dServices['name'] . "<br/>";
                            }
                        }
                    }
                } else {
                    echo 'Failed to get services';
                }
            }
        }
    }
    public function getServicesSosmedUndrCtrl($name)
    {
        if (empty($name)) {
            echo 'Please input name';
        } else {
            $providerData = Providers::where([['name', $name], ['type', 'UNDRCTRL']])->first();
            if (empty($providerData)) {
                echo 'Provider not found';
            } else {
                $urlServices = $providerData->api_url_service;
                $data_post = array('key' => $providerData->api_key, 'action' => 'services');
                $getServices = post_curl($urlServices, $data_post);

                foreach ($getServices as $dServices) {
                    $priceKurs = $dServices['rate'];
                    if (get_config('provider_markup') == "persen") {
                        $persen = $providerData->markup / 100;
                        $price = $priceKurs + ($priceKurs * $persen);
                    } else {
                        $price = $priceKurs + $providerData->markup;
                    }

                    $check = Services::where('service_id', $dServices['service'])->where('provider', $providerData->id)->first();
                    if (empty($check)) {
                        $dInsert = [
                            'service_id' => $dServices['service'],
                            'provider' => $providerData->id,
                            'name' => $dServices['name'],
                            'price' => $price,
                            'profit' => $dServices['rate'],
                            'min' => $dServices['min'],
                            'max' => $dServices['max'],
                            'description' => $dServices['name'],
                            'status' => 1,
                        ];
                        $insert = Services::create($dInsert);
                        if ($insert) {
                            echo "Inserted: " . $dServices['name'] . "<br/>";
                        } else {
                            echo "Failed: " . $dServices['name'] . "<br/>";
                        }
                    } else {
                        $dUpdate = [
                            'service_id' => $dServices['service'],
                            'provider' => $providerData->id,
                            'name' => $check->name,
                            'price' => $price,
                            'profit' => $dServices['rate'],
                            'min' => $dServices['min'],
                            'max' => $dServices['max'],
                            'status' => 1,
                        ];
                        $update = Services::where('id', $check->id)->update($dUpdate);
                        if ($update) {
                            echo "Update: " . $check->name . " HARGA: " . $price . " HARGA DARI PROVIDER : " . $dServices['rate'] . " ID Layanan : " . $dServices['service'] . "<br/>";
                        } else {
                            echo "Failed Update: " . $check->name . " HARGA: " . $price . " HARGA: " . $price . " ID Layanan : " . $dServices['service'] . "<br/>";
                        }
                    }
                }
            }
        }
    }
    public function cron_sosmed()
    {
        $this->status_sosmed();
        $this->refund_sosmed();
    }
    public function status_sosmed()
    {
        OrdersSosmed::query()->whereIn('status', array('Pending', 'Processing'))->chunk(50, function ($data) {
            try {
                foreach ($data as $order) {
                    $provider = Providers::where('id', $order->provider)->first();
                    if (empty($provider) || is_null($provider)) {
                        echo 'Provider Not Found <br/>';
                    }
                    if ($provider->type == "LUAR") {
                        $url = $provider->api_url_status;
                        $data = array(
                            'key' => $provider->api_key,
                            'action' => 'status',
                            'order' => $order['order_id']
                        );
                        $curl = post_curl($url, $data);
                        $result = $curl;
                        if (isset($curl['error'])) {
                            $status = 'Pending';
                            $start_count = 0;
                            $remains = 0;
                            echo 'Terjadi kesalahan dalam proses pengambilan data <br/>';
                        } else {
                            $start_count = !isset($result['start_count']) ? 0 : $result['start_count'];
                            $remains = !isset($result['remains']) ? 0 : $result['remains'];
                            if (!isset($result['status'])) {
                                $status = "Pending";
                            } else if ($result['status'] == "Pending") {
                                $status = "Pending";
                            } else if ($result['status'] == "In progress" || $result['status'] == "Processing") {
                                $status = "Processing";
                            } else if ($result['status'] == "Partial") {
                                $status = "Partial";
                            } else if ($result['status'] == "Canceled") {
                                $status = "Error";
                            } else if ($result['status'] == "Completed") {
                                $status = "Success";
                            } else {
                                $status = "Pending";
                            }
                        }
                    } else if ($provider->type == "INDO") {
                        $url = $provider->api_url_status;
                        $data = array(
                            'api_id' => $provider->api_id,
                            'api_key' => $provider->api_key,
                            'id' => $order['order_id']
                        );
                        $curl = post_curl($url, $data);
                        $result = $curl;
                        if (empty($curl) || $curl['status'] == false) {
                            continue;
                            $status = 'Pending';
                            $start_count = 0;
                            $remains = 0;
                            echo 'Terjadi kesalahan dalam proses pengambilan data <br/>';
                        } else {
                            $status = $result['data']['status'];
                            $start_count = $result['data']['start_count'];
                            $remains = $result['data']['remains'];
                        }
                    } else if ($provider->type == "INDO OLD") {
                        $url = $provider->api_url_status;
                        $data = array(
                            'api_key' => $provider->api_key,
                            'action' => 'status',
                            'id' => $order['order_id']
                        );
                        $curl = post_curl($url, $data);
                        $result = $curl;
                        if (empty($curl) || $curl['status'] == false) {
                            continue;
                            $status = 'Pending';
                            $start_count = 0;
                            $remains = 0;
                            echo 'Terjadi kesalahan dalam proses pengambilan data <br/>';
                        } else {
                            $status = $result['data']['status'];
                            $start_count = !isset($result['data']['start_count']) ? 0 : $result['data']['start_count'];
                            $remains = !isset($result['data']['remains']) ? 0 : $result['data']['remains'];
                        }
                    } else if ($provider->type == "BuzzerPanel") {
                        $url = $provider->api_url_status;
                        $data = array(
                            'api_key' => $provider->api_key,
                            'secret_key' => $provider->api_id,
                            'action' => 'status',
                            'id' => $order['order_id']
                        );
                        $curl = post_curl($url, $data);
                        $result = $curl;
                        if ($curl['status'] == false || empty($curl)) {
                            $status = 'Pending';
                            $start_count = 0;
                            $remains = 0;
                            echo 'Terjadi kesalahan dalam proses pengambilan data <br/>';
                        } else {
                            $status = $result['data']['status'];
                            if ($status == "Pending") {
                                $status = "Pending";
                            } else if ($status == "Processing" || $status == "In progress") {
                                $status = "Processing";
                            } else if ($status == "Partial") {
                                $status = "Partial";
                            } else if ($status == "Error") {
                                $status = "Error";
                            } else if ($status == "Success") {
                                $status = "Success";
                            } else {
                                $status = "Pending";
                            }
                            $start_count = $result['data']['start_count'];
                            $remains = $result['data']['remains'];
                        }
                    }
                    if ($status == $order->status) {
                        echo "Order ID: " . $order->id . " Skipped <br/>";
                        continue;
                    } else {
                        $save = OrdersSosmed::where('id', $order->id)->update([
                            'status' => $status,
                            'start_count' => $start_count,
                            'remains' => $remains,
                            'logs_status' => json_encode($result),
                        ]);
                        if ($save) {
                            echo "Success Update Status Order: " . $order->id . "<br/>";
                        } else {
                            echo "Failed Update Status Order: " . $order->id . "<br/>";
                        }
                    }
                }
                DB::commit();
            } catch (\ErrorException $e) {
                DB::rollback();
                return ['error' => 1, 'message' => $e->getMessage()];
            }
        });
    }
    public function refund_sosmed()
    {
        $getOrder = OrdersSosmed::query()->whereIn('status', array('Error', 'Partial'))->where('refund', 0)->get();
        foreach ($getOrder as $order) {
            $priceOne = $order->price / $order->quantity;
            $price = $priceOne * $order->remains;
            if ($order->remains == 0) {
                $price = $priceOne * $order->quantity;
            }
            if ($order->remains > $order->quantity) {
                $price = $priceOne * $order->quantity;
            }
            $order->price = $price;
            $order->refund = 1;

            $user = User::where('id', $order->user_id)->first();
            $user->update([
                'balance' => $user->balance + $price,
            ]);
            Activity::create([
                'user_id' => $user->id,
                'amount' => $price,
                'type' => 'plus',
                'note' => 'Refund Pembelian Layanan ' . $order->service_name . ' dengan Nomor Order ' . $order->id . ' Berhasil di refund',
            ]);
            if ($order->save()) {
                echo "Success Refund Order: " . $order->id . "<br/>";
            } else {
                echo "Failed Refund Order: " . $order->id . "<br/>";
            }
        }
    }
    public function setnewRole()
    {
        $user = \App\Models\User::where('permanent_role', '0')->where('role_id', '!=', 1)->get()->toArray();
        foreach ($user as $dUser) {
            $date = Carbon::now()->format('m-Y');
            $countOrder = \App\Models\OrdersSosmed::where([['date', 'LIKE', '%' . $date . '%'], ['user_id', '=', $dUser['id']]])->sum('price');
            if ($countOrder > 0) {
                $searchRole = \App\Models\Role::where([
                    ['total_spend', '<', $countOrder],
                    ['id', '!=', $dUser['role_id']],
                ])->first();
                $update = \App\Models\User::where('id', $dUser['id'])->update([
                    'role_id' => $searchRole->id
                ]);
                if ($update) {
                    echo 'Berhasil Memperbaharui Role User <br/>';
                } else {
                    echo 'Gagal Memperbaharui Role User <br/>';
                }
            } else {
                $update = \App\Models\User::where('id', $dUser['id'])->update([
                    'role_id' => 1
                ]);
                if ($update) {
                    echo 'Berhasil Mereset Role User <br/>';
                } else {
                    echo 'Gagal Mereset Role User <br/>';
                }
            }
        }
    }
}
