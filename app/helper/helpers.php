<?php

use App\Models\Config;
use App\Models\Deposit;
use App\Models\FavoriteServices;
use App\Models\OrdersSosmed;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('get_config')) {
    function get_config($name)
    {
        $data = Config::where('name', $name)->first();
        if ($data) {
            return $data['value'];
        } else {
            return $name;
        }
    }
}
if (!function_exists('render_logo')) {
    function render_logo($type)
    {
        if ($type == "dark") {
            $data = get_config('site_logo_dark');
            if ($data === "site_logo_dark") {
                return asset('bigonepanel.png');
            } else {
                return asset('assets/uploaded' . $data);
            }
        } else {
            $data = get_config('site_logo_light');
            if ($data === "site_logo_light") {
                return asset('bigonepanel.png');
            } else {
                return asset('assets/uploaded' . $data);
            }
        }
    }
}
if (!function_exists('render_logo_small')) {
    function render_logo_small($type)
    {
        if ($type == "dark") {
            $data = get_config('site_logo_small_dark');
            if ($data === "site_logo_small_dark") {
                return asset('assets/images/logo-dark-sm.png');
            } else {
                return asset('assets/uploaded' . $data);
            }
        } else {
            $data = get_config('site_logo_small_light');
            if ($data === "site_logo_small_light") {
                return asset('assets/images/logo-light.png');
            } else {
                return asset('assets/uploaded' . $data);
            }
        }
    }
}
if (!function_exists("removeWhiteSpace")) {

    function removeWhiteSpace($string)
    {

        return strtolower(str_replace(" ", "-", $string));
    }
}
if (!function_exists('thousandsCurrencyFormat')) {
    function thousandsCurrencyFormat($num)
    {
        if ($num >= 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'jt', 'm', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }
}
if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}
if (!function_exists('countOrderPerMonth')) {
    function countOrderPerMonth()
    {
        $user = Auth::user();
        $date = Carbon::now()->format('m-Y');
        $countOrder = OrdersSosmed::where([['date', 'LIKE', '%' . $date . '%'], ['user_id', '=', $user->id]])->sum('price');
        return $countOrder;
    }
}
if (!function_exists('nextRoles')) {
    function nextRoles()
    {
        $totalOrder = countOrderPerMonth();
        $user = Auth::user();
        $searchRole = Role::where([
            ['total_spend', '>', $totalOrder],
            ['id', '>', $user->role_id],
            ['private', 0]
        ])->first();
        return $searchRole;
    }
}
if (!function_exists('nextTarget')) {
    function nextTarget()
    {
        $totalOrder = countOrderPerMonth();
        $user = Auth::user();
        $searchRole = Role::where([
            ['total_spend', '>', $totalOrder],
            ['id', '>', $user->role_id],
            ['private', 0]
        ])->first();
        if ($searchRole) {
            $persen = $totalOrder / $searchRole['total_spend'] * 100;
        } else {
            $persen = 100;
        }
        return "
        <div class='progress-bar bg-warning bg-gradient' role='progressbar' style='width: " . $persen . "%' aria-valuenow='" . $persen . "' aria-valuemin='0' aria-valuemax='100'></div>
        ";
    }
}
if (!function_exists('getDays7Before')) {
    function getDays7Before()
    {
        $date = array();
        for ($i = 0; $i <= 7; $i++) {
            array_push($date, Carbon::now()->subDays($i)->format('d-m-Y'));
        }
        return array_reverse($date);
    }
}
if (!function_exists('data7days')) {
    function data7days()
    {
        $user = Auth::user();
        $date = getDays7Before();
        $data = [];
        foreach ($date as $tanggal) {
            $smm = OrdersSosmed::where('date', 'like', '%' . $tanggal . '%')->where('user_id', $user->id)->count();
            $ppob = Deposit::whereDate('created_at', 'LIKE', '%' . $tanggal . '%')->count();
            $data['date'][] = $tanggal;
            $data['order'][] = $smm;
            $data['deposit'][] = $ppob;
        }
        return $data;
    }
}
if (!function_exists('persen')) {
    function persen($num)
    {
        return number_format($num, 1);
    }
}
if (!function_exists('obfuscate_email')) {
    function obfuscate_email($email)
    {
        $em   = explode("@", $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len  = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
if (!function_exists('userLogin')) {
    function userLogin()
    {
        $user = Auth::user();
        $role = Role::where('id', $user->id)->first();
        return ['user' => $user, 'role' => empty($role) ? 'Tamu' : $role->name];
    }
}
if (!function_exists('post_curl')) {
    function post_curl($end_point, $post)
    {
        $_post = array();
        if (is_array($post)) {
            foreach ($post as $name => $value) {
                $_post[] = $name . '=' . urlencode($value);
            }
        }
        $ch = curl_init($end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }
        curl_close($ch);
        $json = json_decode($result, TRUE);
        return $json;
    }
}
if (!function_exists('favServices')) {
    function favServices($id)
    {
        $user = Auth::user();
        if (empty($user)) {
            return false;
        } else {
            $check = FavoriteServices::where([
                ['user_id', $user->id],
                ['service_id', $id]
            ])->first();
            if (empty($check)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
if (!function_exists('benefit_role')) {
    function benefit_role($role_id)
    {
        return \App\Models\Role::where('id', $role_id)->first();
    }
}
if (!function_exists('data7days')) {
    function data7days()
    {
        $user = Auth::user();
        $date = getDays7Before();
        $data = [];
        foreach ($date as $tanggal) {
            $smm = OrdersSosmed::where('date', 'like', '%' . $tanggal . '%')->where('user_id', $user->id)->count();
            $data['date'][] = $tanggal;
            $data['sosmed'][] = $smm;
        }
        return $data;
    }
}
if (!function_exists('order7days')) {
    function order7days()
    {
        $date = getDays7Before();
        $data = [];
        foreach ($date as $tanggal) {
            $smm = OrdersSosmed::where('date', 'like', '%' . $tanggal . '%')->count();
            $data['date'][] = $tanggal;
            $data['sosmed'][] = $smm;
        }
        return $data;
    }
}
if (!function_exists('balance_all_user')) {
    function balance_all_user()
    {
        return \App\Models\User::sum('balance');
    }
}
if (!function_exists('count_user')) {
    function count_user()
    {
        return \App\Models\User::count();
    }
}
if (!function_exists('count_order')) {
    function count_order()
    {
        $smm = \App\Models\OrdersSosmed::count();
        return ['total' => $smm, 'sosmed' => $smm];
    }
}
if (!function_exists('user_count_order')) {
    function user_count_order()
    {
        $user = Auth::user();
        $smm = \App\Models\OrdersSosmed::where('user_id', $user->id)->count();
        $rupiah_smm = \App\Models\OrdersSosmed::where('user_id', $user->id)->sum('price');
        return ['total' => $smm, 'sosmed' => $smm, 'total_price' => $rupiah_smm, 'sosmed_price' => $rupiah_smm];
    }
}
if (!function_exists('count_deposit')) {
    function count_deposit()
    {
        $deposit_amount = \App\Models\Deposit::where('status', 'Success')->sum('get');
        $deposit_count = \App\Models\Deposit::where('status', 'Success')->count();
        return ['amount' => $deposit_amount, 'count' => $deposit_count];
    }
}
if (!function_exists('user_count_deposit')) {
    function user_count_deposit()
    {
        $user = Auth::user();
        $deposit_amount = \App\Models\Deposit::where('status', 'Success')->where('user_id', $user->id)->sum('get');
        $deposit_count = \App\Models\Deposit::where('status', 'Success')->where('user_id', $user->id)->count();
        return ['amount' => $deposit_amount, 'count' => $deposit_count];
    }
}
