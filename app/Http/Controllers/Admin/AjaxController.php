<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Categories;
use App\Models\Config;
use App\Models\Deposit;
use App\Models\Method;
use App\Models\News;
use App\Models\OrderRequest;
use App\Models\OrdersGames;
use App\Models\OrdersPpob;
use App\Models\OrdersSosmed;
use App\Models\Providers;
use App\Models\Role;
use App\Models\Services;
use App\Models\TicketReply;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function adminAuthenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ], [
                'email.required' => 'Email is required',
                'email.email' => 'Email not valid',
                'password.required' => 'Password is required',
            ]);

            $credentials = $request->only('email', 'password');
            if (!auth()->guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) throw new \ErrorException('Tidak dapat memverifikasi akun anda');
            return response()->json([
                'status' => true,
                'message' => 'Success Login'
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function news(Request $request)
    {
        try {
            if ($request->status == "add") {
                $validateData = $this->validate(
                    $request,
                    [
                        'content' => 'required|sometimes',
                        'type' => 'required|sometimes'
                    ]
                );
                $content = $validateData['content'];
                $dom = new \DomDocument();
                $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $imageFile = $dom->getElementsByTagName('imageFile');

                foreach ($imageFile as $item => $image) {
                    $data = $image->getAttribute('src');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $imgeData = base64_decode($data);
                    $image_name = "/upload/" . time() . $item . '.png';
                    $path = public_path() . $image_name;
                    file_put_contents($path, $imgeData);

                    $image->removeAttribute('src');
                    $image->setAttribute('src', $image_name);
                }
                $validateData['content'] = $dom->saveHTML();

                $add = News::create($validateData);
                User::query()->update([
                    'read_news' => 0,
                ]);
                if (!$add) throw new \ErrorException('Berita Gagal ditambahkan');
                $message = "Berhasil Tambah Berita";
            } else if ($request->status == "edit") {
                $validateData = $this->validate(
                    $request,
                    [
                        'content' => 'required|sometimes',
                        'type' => 'required|sometimes'
                    ]
                );
                $content = $validateData['content'];
                $dom = new \DomDocument();
                $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $imageFile = $dom->getElementsByTagName('imageFile');

                foreach ($imageFile as $item => $image) {
                    $data = $image->getAttribute('src');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $imgeData = base64_decode($data);
                    $image_name = "/upload/" . time() . $item . '.png';
                    $path = public_path() . $image_name;
                    file_put_contents($path, $imgeData);

                    $image->removeAttribute('src');
                    $image->setAttribute('src', $image_name);
                }
                $validateData['content'] = $dom->saveHTML();
                $update = News::where('id', $request->id)->update($validateData);
                User::query()->update([
                    'read_news' => 0,
                ]);
                if (!$update) throw new \ErrorException('Berita Gagal diupdate');
                $message = "Berhasil Update Berita";
            } else if ($request->status == "hapus") {
                $delete = News::where('id', $request->id)->delete();
                if (!$delete) throw new \ErrorException('Berita Gagal dihapus');
                $message = "Berhasil Hapus Berita";
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function deposit(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request['action'] == "accept") {
                $depo_data = Deposit::where('id', $request['id'])->first();
                $depo_data->toArray();
                $user = User::where('id', $depo_data['user_id'])->first();
                $user->toArray();
                $dataActivity = [
                    'user_id' => $user['id'],
                    'type' => 'plus',
                    'amount' => $depo_data['amount'],
                    'note' => 'Deposit #' . $depo_data['id'] . ' Berhasil dikonfirmasi oleh admin'
                ];
                Activity::create($dataActivity);
                Deposit::where('id', $depo_data['id'])->update(['status' => 'Success']);
                User::where('id', $user['id'])->update(['balance' => $user['balance'] + $depo_data['get']]);
                $message = "Berhasil Mengkonfirmasi Deposit";
            } else if ($request['action'] == "cancel") {
                $depo_data = Deposit::where('id', $request['id'])->first();
                $depo_data->toArray();

                if ($depo_data['status'] == "Success") throw new \ErrorException('Deposit Sudah Success, tidak bisa dibatalkan');
                $update = Deposit::where('id', $depo_data['id'])->update(['status' => 'Canceled']);
                if (!$update) throw new \ErrorException('Deposit Gagal Dibatalkan');
                $message = "Deposit Berhasil dibatalkan";
            } else if ($request['action'] == "tarik") {
                $depo_data = Deposit::where('id', $request['id'])->first();
                $depo_data->toArray();
                if ($depo_data['status'] !== "Success") throw new \ErrorException('Deposit Belum Success, tidak bisa ditarik');
                $user = User::where('id', $depo_data['user_id'])->first();
                $dataActivity = [
                    'user_id' => $user->id,
                    'type' => 'minus',
                    'amount' => $depo_data['amount'],
                    'note' => 'Deposit #' . $depo_data->id . ' Berhasil ditarik kembali'
                ];
                Activity::create($dataActivity);
                Deposit::where('id', $depo_data['id'])->update(['status' => 'Pending']);
                User::where('id', $user->id)->update(['balance' => $user->balance - $depo_data['get']]);
                $message = "Saldo Berhasil ditarik kembali";
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {

            DB::rollback();
            /* Transaction failed. */
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function method(Request $request)
    {
        try {
            if ($request->status == "add") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'note' => 'required|sometimes',
                        'rate' => 'required|sometimes',
                        'min' => 'required|sometimes',
                        'bonus' => 'required|sometimes',
                    ]
                );
                if ($request->hasFile('icon')) {
                    $images = $request->file('icon');
                    $images->move(public_path('icon/'), $images->getClientOriginalName());
                    $validateData['icon'] = $images->getClientOriginalName();
                }
                $insert = Method::create($validateData);
                if (!$insert) throw new \ErrorException('Gagal menambahkan Metode Deposit');
                $message = "Berhasil Menambahkan Metode Deposit";
            } else if ($request->status == "edit") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'note' => 'required|sometimes',
                        'rate' => 'required|sometimes',
                        'min' => 'required|sometimes',
                        'bonus' => 'required|sometimes',
                    ]
                );
                $getOld = Method::where('id', $request->id)->first();
                if ($request->hasFile('icon')) {
                    // if (file_exists(public_path('icon/' . $getOld['icon']))) {
                    //     unlink(public_path('icon/' . $getOld['icon']));
                    // }
                    $images = $request->file('icon');
                    $images->move(public_path('icon/'), $images->getClientOriginalName());
                    $validateData['icon'] = $images->getClientOriginalName();
                } else {
                    $validateData['icon'] = $getOld['icon'];
                }
                $update = Method::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Metode Deposit');
                $message = "Berhasil Mengupdate Metode Deposit";
            } else if ($request->status == "hapus") {
                $getOld = Method::where('id', $request->id)->first();
                if (file_exists(public_path('icon/' . $getOld['icon']))) {
                    unlink(public_path('icon/' . $getOld['icon']));
                }
                $delete = Method::where('id', $request->id)->delete();
                if (!$delete) throw new \ErrorException('Gagal Menghapus Metode Deposit');
                $message = "Berhasil Menghapus Metode Deposit";
            } else {
                throw new \ErrorException('Undefined Methods');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function category(Request $request)
    {
        try {
            if ($request->status == "add") {
                if (is_null($request->name)) {
                    return ['error' => 1, 'message' => 'Failed Insert New Categories'];
                }
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes|unique:categories',
                        // 'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                    ]
                );
                $insert = Categories::create($validateData);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Kategori');
                $message = "Berhasil Menambahkan Kategori";
            } else if ($request->status == "edit") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        // 'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
                    ]
                );
                $update = Categories::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Kategori');
                $message = "Berhasil Mengupdate Kategori";
            } else if ($request->status == "hapus") {
                $delete = Categories::where('id', $request->id)->delete();
                if (!$delete) throw new \ErrorException('Gagal Menghapus Kategori');
                $message = "Berhasil Menghapus Kategori";
            } else {
                throw new \ErrorException('Undefined Methods');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function provider(Request $request)
    {
        try {
            if ($request->status == "add") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'api_url_order' => 'required|sometimes',
                        'api_url_status' => 'required|sometimes',
                        'api_url_service' => 'required|sometimes',
                        'api_url_profile' => 'required',
                        'api_url_refill' => 'required',
                        'api_key' => 'required|sometimes',
                        'api_id' => 'sometimes',
                        'markup' => 'sometimes',
                        'type' => 'required|sometimes',
                    ]
                );
                $insert = Providers::create($validateData);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Provider');
                $message = "Berhasil Menambahkan Provider";
            } else if ($request->status == "edit") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'api_url_order' => 'required|sometimes',
                        'api_url_status' => 'required|sometimes',
                        'api_url_service' => 'required|sometimes',
                        'api_url_profile' => 'required',
                        'api_url_refill' => 'required',
                        'api_key' => 'required|sometimes',
                        'api_id' => 'sometimes',
                        'markup' => 'sometimes',
                        'type' => 'required|sometimes',
                    ]
                );
                $update = Providers::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Provider');
                $message = "Berhasil Mengupdate Provider";
            } else if ($request->status == "hapus") {
                $delete =  Providers::where('id', $request->id)->delete();
                if (!$delete) throw new \ErrorException('Gagal Menghapus Provider');
                $message = "Berhasil Menghapus Provider";
            } else {
                throw new \ErrorException('Undefined Methods');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function services(Request $request)
    {
        try {
            if ($request['status'] == "add") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'category_id' => 'required|sometimes',
                        'description' => 'required|sometimes',
                        'price' => 'required|sometimes',
                        'profit' => 'required|sometimes',
                        'min' => 'required|sometimes',
                        'max' => 'required|sometimes',
                        'type' => 'required|in:Default,Custom Comments,Custom Likes',
                        'provider' => 'required|sometimes',
                        'is_canceled' => 'required|sometimes',
                        'is_refill' => 'required|sometimes',
                        'service_id' => 'required|sometimes',
                    ]
                );
                $insert = Services::create($validateData);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Layanan Social Media');
                $message = "Berhasil Menambahkan Layanan Social Media";
            } else if ($request['status'] == "edit") {
                $validateData = $this->validate(
                    $request,
                    [
                        'name' => 'required|sometimes',
                        'category_id' => 'required|sometimes',
                        'description' => 'required|sometimes',
                        'price' => 'required|sometimes',
                        'profit' => 'required|sometimes',
                        'min' => 'required|sometimes',
                        'max' => 'required|sometimes',
                        'type' => 'required|in:Default,Custom Comments,Custom Likes',
                        'provider' => 'required|sometimes',
                        'is_canceled' => 'required|sometimes',
                        'is_refill' => 'required|sometimes',
                        'service_id' => 'required|sometimes',
                    ]
                );
                $validateData['status'] = $request['status_services'];
                $update = Services::where('id', $request['id'])->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Layanan Social Media');
                $message = "Berhasil Mengupdate Layanan Social Media";
            } else if ($request['status'] == "hapus") {
                $delete = Services::where('id', $request['id'])->delete();
                if (!$delete) throw new \ErrorException('Gagal Menambahkan Layanan Social Media');
                $message = "Berhasil Menambahkan Layanan Social Media";
            } else {
                throw new \ErrorException('Undefined Methods');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function detailOrderSocial($id)
    {
        return OrdersSosmed::find($id);
    }
    public function editSocial(Request $request)
    {
        try {
            $validateData = $this->validate(
                $request,
                [
                    'id' => 'required|numeric',
                    'status' => 'required',
                    'start_count' => 'required',
                    'remains' => 'required',
                ],
                [
                    'id.required' => 'ID Harus Diisi',
                    'id.numeric' => 'ID Harus Angka',
                    'status.required' => 'Status Harus Diisi',
                    'start_count.required' => 'Start Count Harus Diisi',
                    'remains.required' => 'Remains Harus Diisi',
                ]
            );
            $order = OrdersSosmed::find($validateData['id']);
            if (is_null($order)) throw new \ErrorException('Pesanan tidak ditemukan');
            $order->status = $validateData['status'];
            $order->start_count = $validateData['start_count'];
            $order->remains = $validateData['remains'];
            $order->save();
            return response()->json([
                'error' => false,
                'message' => 'Berhasil update pesanan'
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function user(Request $request)
    {
        try {
            if ($request->status == "edit") {
                $validateData = $this->validate($request, [
                    'role_id' => 'required|numeric',
                    'permanent_role' => 'required|numeric',
                    'email_verify_status' => 'required|numeric',
                ], [
                    'role_id.required' => 'Role Harus Diisi',
                    'role_id.numeric' => 'Role Harus Angka',
                    'permanent_role.required' => 'Permanen Role Harus Diisi',
                    'permanent_role.numeric' => 'Permanen Role Harus Dipilih Salah Satu',
                    'email_verify_status.required' => 'Email Verify Status Harus Diisi',
                    'email_verify_status.numeric' => 'Email Verify Status Harus Angka',
                ]);
                $update = User::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate user');
                $message = "Berhasil Mengupdate user";
            } else if ($request->status == "hapus") {
                $update = User::where('id', $request->id)->delete();
                if (!$update) throw new \ErrorException('Gagal Menghapus user');
                $message = "Berhasil Menghapus user";
            } else {
                throw new \ErrorException('Undefined Action');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function role(Request $request)
    {
        try {
            if ($request->status == "add") {
                $validateData = $this->validate($request, [
                    'name' => 'required',
                    'total_spend' => 'required',
                    'total_discount' => 'required',
                    'bonus_deposit' => 'required',
                    'private' => 'required',
                ], [
                    'name.required' => 'Nama Harus Diisi',
                    'total_spend.required' => 'Total Spend Harus Diisi',
                    'total_discount.required' => 'Total Discount Harus Diisi',
                    'bonus_deposit.required' => 'Bonus Deposit Harus Diisi',
                    'private.required' => 'Pilihan Role Private Harus Diisi',
                ]);
                $insert = Role::create($validateData);
                if (!$insert) throw new \ErrorException('Gagal Menambahkan Role');
                $message = "Berhasil Menambahkan Role";
            } else if ($request->status == "edit") {
                $validateData = $this->validate($request, [
                    'name' => 'required',
                    'total_spend' => 'required',
                    'total_discount' => 'required',
                    'bonus_deposit' => 'required',
                    'private' => 'required',
                ], [
                    'name.required' => 'Nama Harus Diisi',
                    'total_spend.required' => 'Total Spend Harus Diisi',
                    'total_discount.required' => 'Total Discount Harus Diisi',
                    'bonus_deposit.required' => 'Bonus Deposit Harus Diisi',
                    'private.required' => 'Pilihan Role Private Harus Diisi',
                ]);
                $update = Role::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Gagal Mengupdate Role');
                $message = "Berhasil Mengupdate Role";
            } else if ($request->status == "hapus") {
                $update = Role::where('id', $request->id)->delete();
                if (!$update) throw new \ErrorException('Gagal Menghapus Role');
                $message = "Berhasil Menghapus Role";
            } else {
                throw new \ErrorException('Undefined Action');
            }
            return response()->json([
                'error' => false,
                'message' => $message
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function setting_update(Request $request)
    {
        try {
            $validateData = $this->validate($request, [
                'site_name' => 'required',
                'provider_markup' => 'required|in:persen,nominal',
                'meta_description' => 'required',
                'meta_keyword' => 'required',
                'meta_color' => 'required',
                'rate_usd' => 'required|numeric',
                'bonus_payment_gateway' => 'required|numeric',
                'deposit_minimal' => 'required|numeric',
                'saldo_minimal' => 'required|numeric',
            ], [
                'site_name.required' => 'Nama Website Harus Diisi',
                'provider_markup.required' => 'Provider Markup Harus Diisi',
                'provider_markup.in' => 'Provider Markup Harus Diisi',
                'meta_description.required' => 'Provider Markup Harus Diisi',
                'meta_color.required' => 'Provider Markup Harus Diisi',
                'meta_keyword.required' => 'Provider Markup Harus Diisi',
                'rate_usd.required' => 'Rate USD Harus Diisi',
                'rate_usd.numeric' => 'Rate USD Harus Angka',
                'bonus_payment_gateway.required' => 'Bonus Payment Gateway Harus Diisi',
                'bonus_payment_gateway.numeric' => 'Bonus Payment Gateway Harus Angka',
                'deposit_minimal.required' => 'Deposit Minimal Harus Diisi',
                'deposit_minimal.numeric' => 'Deposit Minimal Harus Angka',
                'saldo_minimal.required' => 'Saldo Minimal Harus Diisi',
                'saldo_minimal.numeric' => 'Saldo Minimal Harus Angka',
            ]);
            if ($request->hasFile('logo')) {
                $images = $request->file('logo');
                $images->move(public_path('/'), $images->getClientOriginalName());
                $validateData['logo'] = $images->getClientOriginalName();
            }
            if ($request->hasFile('logo_dark')) {
                $images = $request->file('logo_dark');
                $images->move(public_path('/'), $images->getClientOriginalName());
                $validateData['logo_dark'] = $images->getClientOriginalName();
            }
            if ($request->hasFile('icon')) {
                $images = $request->file('icon');
                $images->move(public_path('/'), $images->getClientOriginalName());
                $validateData['icon'] = $images->getClientOriginalName();
            }
            foreach ($validateData as $key => $value) {
                $setting = Config::where('name', $key)->first();
                if ($setting) {
                    $setting->value = $value;
                    $setting->save();
                } else {
                    Config::create([
                        'name' => $key,
                        'value' => $value,
                    ]);
                }
            }
            return response()->json([
                'error' => false,
                'message' => 'Berhasil'
            ]);
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }
    public function pages(Request $request)
    {
        try {
            if ($request->status == "edit") {
                $validateData = $this->validate($request, [
                    'content' => 'required'
                ]);
                $update = \App\Models\Page::where('id', $request->id)->update($validateData);
                if (!$update) throw new \ErrorException('Tidak Dapat Mengupdate Konten Halaman');
                return response()->json([
                    'error' => false,
                    'message' => 'Berhasil'
                ]);
            }
        } catch (\ErrorException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }
    public function tickets(Request $request)
    {
        try {
            $user = auth()->guard('admin')->user();
            if ($request->status == "reply") {
                $validateData = $this->validate($request, [
                    'message' => 'required',
                ], [
                    'message.required' => 'Message Harus Diisi',
                ]);
                $cek_ticket = Tickets::where('id', $request->ticket_id)->first();
                $updateTicket = array(
                    'is_reply' => 1,
                );

                Tickets::where('id', $cek_ticket->id)->update($updateTicket);
                $insert = TicketReply::create([
                    'ticket_id' => $request->ticket_id,
                    'user_id' => $user->id,
                    'message' => $validateData['message'],
                    'is_admin' => 1
                ]);
                if (!$insert) throw new \ErrorException('Gagal Balas Ticket');
                $message = "Berhasil Balas Ticket";
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
    public function getSaldoProvider()
    {
        $provider = Providers::all()->toArray();
        $array = array();
        foreach ($provider as $pd) {
            if ($pd['type'] == "LUAR") {
                $data = array(
                    'key' => $pd['api_key'],
                    'action' => 'balance',
                );
                $curl = post_curl($pd['api_url_profile'], $data);
                array_push($array, array(
                    'name' => $pd['name'],
                    'balance' => isset($curl['balance']) ? $curl['balance'] . ' USD' : "0 USD",
                ));
            } else if ($pd['type'] == "UNDRCTRL") {
                $data = array(
                    'key' => $pd['api_key'],
                    'action' => 'balance',
                );
                $curl = post_curl($pd['api_url_profile'], $data);
                array_push($array, array(
                    'name' => $pd['name'],
                    'balance' => isset($curl['balance']) ? rupiah($curl['balance']) : rupiah(0),
                ));
            } else if ($pd['type'] == "INDO") {
                $data = array(
                    'api_key' => $pd['api_key'],
                    'api_id' => $pd['api_id'],
                );
                $curl = post_curl($pd['api_url_profile'], $data);
                array_push($array, array(
                    'name' => $pd['name'],
                    'balance' => isset($curl['data']['balance']) ? rupiah($curl['data']['balance']) : rupiah(0),
                ));
            } else if ($pd['type'] == "INDO OLD") {
                $data = array(
                    'api_key' => $pd['api_key'],
                    'action' => 'profile'
                );
                $curl = post_curl($pd['api_url_profile'], $data);
                array_push($array, array(
                    'name' => $pd['name'],
                    'balance' => isset($curl['data']['balance']) ? rupiah($curl['data']['balance']) : rupiah(0),
                ));
            } else if ($pd['type'] == "BuzzerPanel") {
                $data = array(
                    'api_key' => $pd['api_key'],
                    'secret_key' => $pd['api_id'],
                    'action' => 'profile',
                );
                $curl = post_curl($pd['api_url_profile'], $data);
                array_push($array, array(
                    'name' => $pd['name'],
                    'balance' => isset($curl['data']['balance']) ? rupiah($curl['data']['balance']) : rupiah(0),
                ));
            }
        }
        return $array;
    }
    public function OrderRequest(Request $request)
    {
        DB::beginTransaction();
        try {
            $validate = $this->validate($request, [
                'id' => 'required',
                'status' => 'required'
            ], [
                'id.required' => 'Terjadi kesalahan',
                'status' => 'Status Wajib Dipilih'
            ]);
            $orderReq = OrderRequest::where('id', $validate['id'])->first();
            $order = OrdersSosmed::where('id', $orderReq['order_id'])->first();
            if (empty($orderReq)) throw new \ErrorException('Permintaan Pesanan tidak ditemukan');
            if (empty($order)) throw new \ErrorException('Pesanan tidak ditemukan');
            if ($validate['status'] == "Success" && $orderReq['type'] == "Cancel") {
                $updateOrder = OrdersSosmed::where('id', $orderReq['order_id'])->update([
                    'status' => 'Canceled'
                ]);
                if (!$updateOrder) throw new \ErrorException('Terjadi kesalahan ketika melakukan update pada pemesanan');
                $updateReqOrder = OrderRequest::where('id', $validate['id'])->update([
                    'status' => 'Success'
                ]);
                if (!$updateReqOrder) throw new \ErrorException('Terjadi kesalahan ketika melakukan update pada permintaan');
                $message = "Berhasil melakukan update permintaan cancel";
            } else {
                $updateReqOrder = OrderRequest::where('id', $validate['id'])->update([
                    'status' => $validate['status']
                ]);
                if (!$updateReqOrder) throw new \ErrorException('Terjadi kesalahan ketika melakukan update pada permintaan');
                $message = "Berhasil melakukan update permintaan pesanan";
            }
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => $message,
            ]);
        } catch (\ErrorException $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'getLine' => $e->getLine()
            ]);
        }
    }
}
