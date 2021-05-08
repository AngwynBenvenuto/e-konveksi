<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Auth, Hash;
use Lintas\libraries\CData;
use Lintas\libraries\CUserLogin;
use Lintas\helpers\cdbutils;
use Lintas\helpers\utils;
use Lintas\helpers\carr;
use Lintas\helpers\cobj;
use Lintas\helpers\cmsg;
use Lintas\helpers\cnotif;
use Illuminate\Support\Arr;
use App\Models\Delivery;

class CheckoutController extends AdminController {
    public function index() {
        return $this->address();
    }

    public function address() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = array_merge($_GET, $_POST);

        //$transaksi_id = \Session::get('transaksi_id');
        $billing_country_id = '';
        $billing_province_id = '';
        $billing_city_id = '';
        $billing_districts_id = '';
        $billing_name = '';
        $billing_email = '';
        $billing_phone = '';
        $billing_address = '';
        $billing_zipcode = '';
        $billing_lat = '';
        $billing_long = '';

        $same_billing_address = false;

        $shipping_country_id = '';
        $shipping_province_id = '';
        $shipping_city_id = '';
        $shipping_districts_id = '';
        $shipping_name = '';
        $shipping_email = '';
        $shipping_phone = '';
        $shipping_address = '';
        $shipping_zipcode = '';
        $shipping_lat = '';
        $shipping_long = '';
        $billing_address = '';
        $shipping_address = '';

        $province_txt = '';
        $city_txt = '';
        $name_txt = '';
        $email_txt = '';
        $phone_txt = '';
        $address_txt = '';
        $zipcode_txt = '';
        $orderData = \Session::get('order_data');
        if($orderData != null) {
            foreach($orderData as $row_order) {
                $province_txt = $row_order['billing_address']['province_id'];
                $name_txt = $row_order['billing_address']['first_name'];
                $city_txt = $row_order['billing_address']['city_id'];
                $email_txt = $row_order['billing_address']['email'];
                $phone = $row_order['billing_address']['phone'];
                $address_txt = $row_order['billing_address']['address'];
                $zipcode_txt = $row_order['billing_address']['zip_code'];
                $zipcode_txt = $row_order['billing_address']['postal_code'];
            }
        }

        if ($request != null) {
            $billing_province_id = Arr::get($request, 'billing_province_id');
            $billing_city_id = Arr::get($request, 'billing_city_id');
            //$billing_districts_id = Arr::get($request, 'billing_districts_id');
            $billing_name = Arr::get($request, 'billing_name');
            $billing_email = Arr::get($request, 'billing_email');
            $billing_phone = Arr::get($request, 'billing_phone');
            $billing_zipcode = Arr::get($request, 'billing_postal');
            $billing_address = Arr::get($request, 'billing_address');
            $billing_country_id = Arr::get($request, 'billing_country_id');
            $billing_city_name = Arr::get($request, 'billing_city_name');
            $billing_province_name = Arr::get($request, 'billing_province_name');
            $billing_districts_name = Arr::get($request, 'billing_district_name');
            $billing_lat = Arr::get($request, 'billing_lat');
            $billing_long = Arr::get($request, 'billing_long');

            $shipping_province_id = Arr::get($request, 'shipping_province_id');
            $shipping_city_id = Arr::get($request, 'shipping_city_id');
            //$shipping_districts_id = Arr::get($request, 'shipping_districts_id');
            $shipping_name = Arr::get($request, 'shipping_name');
            $shipping_email = Arr::get($request, 'shipping_email');
            $shipping_phone = Arr::get($request, 'shipping_phone');
            $shipping_zipcode = Arr::get($request, 'shipping_postal');
            $shipping_address = Arr::get($request, 'shipping_address');
            $shipping_country_id = Arr::get($request, 'shipping_country_id');
            $shipping_city_name = Arr::get($request, 'shipping_city_name');
            $shipping_province_name = Arr::get($request, 'shipping_province_name');
            $shipping_districts_name = Arr::get($request, 'shipping_district_name');
            $shipping_lat = Arr::get($request, 'shipping_lat');
            $shipping_long = Arr::get($request, 'shipping_long');

            // $keys = array(
            //     'billing_province_id', 'billing_city_id', 'billing_districts_id', 'billing_name'
            //     , 'billing_email', 'billing_phone', 'billing_zipcode', 'billing_address'
            //     , 'billing_lat', 'billing_long'
            //     , 'shipping_province_id', 'shipping_city_id', 'shipping_districts_id', 'shipping_name'
            //     , 'shipping_email', 'shipping_phone', 'shipping_zipcode', 'shipping_address'
            //     , 'shipping_lat', 'shipping_long'
            //     , 'shipping_courier', 'shipping_service'
            // );
            // $extracted = carr::extract($request, $keys);
            if($err_code == 0){
                if(strlen($billing_name) == 0) {
                    $err_code = 134;
                    $err_message = "Name Required";
                }
                else if(strlen($billing_email) == 0) {
                    $err_code = 135;
                    $err_message = "Email Required";
                }
                else if(strlen($billing_phone) == 0) {
                    $err_code = 136;
                    $err_message = "Phone Required";
                }
                else if(strlen($billing_province_id) == 0) {
                    $err_code = 137;
                    $err_message = "Province Required";
                }
                else if(strlen($billing_city_id) == 0) {
                    $err_code = 138;
                    $err_message = "City Required";
                }
            }

            if($err_code == 0) {
                $same_billing_address = Arr::get($request, 'same_billing_address', false);
                if ($same_billing_address) {
                    $billing_name = $shipping_name;
                    $billing_email = $shipping_email;
                    $billing_phone = $shipping_phone;
                    $billing_address = $shipping_address;
                    $billing_province_id = $shipping_province_id;
                    $billing_city_id = $shipping_city_id;
                    $billing_districts_id = $shipping_districts_id;
                    $billing_zipcode = $shipping_zipcode;
                }

                $country_code = '94';
                $order_data = array();

                carr::set_path($order_data, 'contact_detail.billing_address.first_name', $billing_name);
                carr::set_path($order_data, 'contact_detail.billing_address.email', $billing_email);
                carr::set_path($order_data, 'contact_detail.billing_address.phone', $billing_phone);
                carr::set_path($order_data, 'contact_detail.billing_address.address', $billing_address);
                carr::set_path($order_data, 'contact_detail.billing_address.province_id', $billing_province_id);
                carr::set_path($order_data, 'contact_detail.billing_address.city_id', $billing_city_id);
                carr::set_path($order_data, 'contact_detail.billing_address.district_id', $billing_districts_id);
                carr::set_path($order_data, 'contact_detail.billing_address.zip_code', $billing_zipcode);
                carr::set_path($order_data, 'contact_detail.billing_address.postal_code', $billing_zipcode);
                $billingProvinceRecord = CData::getProvince(array('province_id' => $billing_province_id));
                carr::set_path($order_data, 'contact_detail.billing_address.province_name', $billing_province_name);
                carr::set_path($order_data, 'contact_detail.billing_address.province', $billing_province_name);
                $billingCityRecord = CData::getCity(array('city_id' => $billing_city_id));
                carr::set_path($order_data, 'contact_detail.billing_address.city_name', $billing_city_name);
                carr::set_path($order_data, 'contact_detail.billing_address.city', $billing_city_name);
                //$billingDistrictsRecord = CData::getDistricts(array('districts_id' => $billing_districts_id));
                //carr::set_path($order_data, 'contact_detail.billing_address.district_name', $billing_districts_name);
                //carr::set_path($order_data, 'contact_detail.billing_address.district', $billing_districts_name);
                carr::set_path($order_data, 'contact_detail.billing_address.country_code', $country_code);
                carr::set_path($order_data, 'contact_detail.billing_address.lat', $billing_lat);
                carr::set_path($order_data, 'contact_detail.billing_address.long', $billing_long);

                carr::set_path($order_data, 'contact_detail.shipping_address.first_name', $shipping_name);
                carr::set_path($order_data, 'contact_detail.shipping_address.email', $shipping_email);
                carr::set_path($order_data, 'contact_detail.shipping_address.phone', $shipping_phone);
                carr::set_path($order_data, 'contact_detail.shipping_address.address', $shipping_address);
                carr::set_path($order_data, 'contact_detail.shipping_address.province_id', $shipping_province_id);
                carr::set_path($order_data, 'contact_detail.shipping_address.city_id', $shipping_city_id);
                carr::set_path($order_data, 'contact_detail.shipping_address.district_id', $shipping_districts_id);
                carr::set_path($order_data, 'contact_detail.shipping_address.zip_code', $shipping_zipcode);
                carr::set_path($order_data, 'contact_detail.shipping_address.postal_code', $shipping_zipcode);
                $shippingProvinceRecord = CData::getProvince(array('province_id' => $shipping_province_id));
                carr::set_path($order_data, 'contact_detail.shipping_address.province_name', $shipping_province_name);
                carr::set_path($order_data, 'contact_detail.shipping_address.province', $shipping_province_name);
                $shippingCityRecord = CData::getCity(array('city_id' => $shipping_city_id));
                carr::set_path($order_data, 'contact_detail.shipping_address.city_name', $shipping_city_name);
                carr::set_path($order_data, 'contact_detail.shipping_address.city', $shipping_city_name);
                //$shippingDistrictsRecord = CData::getDistricts(array('districts_id' => $shipping_districts_id));
                //carr::set_path($order_data, 'contact_detail.shipping_address.district_name', $shipping_districts_name);
                //carr::set_path($order_data, 'contact_detail.shipping_address.district', $shipping_districts_name);
                carr::set_path($order_data, 'contact_detail.shipping_address.country_code', $country_code);
                carr::set_path($order_data, 'contact_detail.shipping_address.lat', $shipping_lat);
                carr::set_path($order_data, 'contact_detail.shipping_address.long', $shipping_long);
                session()->put('order_data', $order_data);
            }

            if($err_code > 0) {
                cmsg::add('error', $err_message);
            } else {
                return redirect(route('admin.checkout.shipping'));
            }

        }

        $data['billing_province'] = CData::getProvince(array('country_id' => $billing_country_id));
        $data['billing_city'] = CData::getCity(array('province_id' => $billing_province_id));
        //$data['billing_districts'] = CData::getDistricts(array('city_id' => $billing_city_id));
        $data['shipping_province'] = CData::getProvince(array('country_id' => $shipping_country_id));
        $data['shipping_city'] = CData::getCity(array('province_id' => $shipping_province_id));
        //$data['shipping_districts'] = CData::getDistricts(array('city_id' => $shipping_city_id));
        $data['billing_province_id'] = $billing_province_id;
        $data['billing_city_id'] = $billing_city_id;
        //$data['billing_districts_id'] = $billing_districts_id;
        $data['billing_name'] = $billing_name;
        $data['billing_email'] = $billing_email;
        $data['billing_phone'] = $billing_phone;
        $data['billing_address'] = $billing_address;
        $data['billing_zipcode'] = $billing_zipcode;
        $data['billing_lat'] = $billing_lat;
        $data['billing_long'] = $billing_long;

        $data['shipping_province_id'] = $shipping_province_id;
        $data['shipping_city_id'] = $shipping_city_id;
        //$data['shipping_districts_id'] = $shipping_districts_id;
        $data['shipping_name'] = $shipping_name;
        $data['shipping_email'] = $shipping_email;
        $data['shipping_phone'] = $shipping_phone;
        $data['shipping_address'] = $shipping_address;
        $data['shipping_zipcode'] = $shipping_zipcode;
        $data['shipping_lat'] = $shipping_lat;
        $data['shipping_long'] = $shipping_long;
        $data['same_billing_address'] = $same_billing_address;

        //checkout 1
        $data['province_txt'] = $province_txt;
        $data['city_txt'] = $city_txt;
        $data['name_txt'] = $name_txt;
        $data['email_txt'] = $email_txt;
        $data['phone_txt'] = $phone_txt;
        $data['address_txt'] = $address_txt;
        $data['zipcode_txt'] = $zipcode_txt;

        $data['title'] = "Checkout - Address";
        return view('admin.checkout.address', $data);
    }

    public function shipping() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $checkoutData = \Session::get('checkout_data');
        $orderData = \Session::get('order_data');
        $bank= \App\Models\Bank::where('status','>',0)->whereIn('name', array('BCA','MANDIRI','BNI','BRI'))->get()->toArray();
        $kurir=\App\Models\DeliveryService::where('status','>', 0)->whereIn('name', array('JNE', 'POS', 'TIKI'))->get()->toArray();
        $project = '';
        $harga = '';
        $destination = '';
        $origin = CUserLogin::get('city_id');//CUserLogin::get('city_id')

        $kurir_txt = '';
        $bank_txt = '';
        $bank_id_txt = '';
        $payment_method_txt = '';
        $payment_total_txt = '';
        $barang_txt = '';
        $shippingOrder = \Session::get('shipping_order');
        if($shippingOrder != null) {
            $kurir_txt = Arr::get($shippingOrder, 'courier');
            $bank_id_txt = Arr::get($shippingOrder, 'bank_id');
            $bank_txt = Arr::get($shippingOrder, 'bank');
            $barang_txt = Arr::get($shippingOrder, 'barang');
            $payment_method_txt = Arr::get($shippingOrder, 'payment_method');
            $payment_total_txt = Arr::get($shippingOrder, 'payment_total');
        }


        $transaksi = self::getDataTransaksi();
        if($transaksi != null) {
            foreach($transaksi as $key => $value) {
                $project = cobj::get($value, 'project_name');
                $code = cobj::get($value, 'code');
                $harga = cobj::get($value, 'transaction_price');
            }
        }

        if($orderData != null) {
            foreach($orderData as $row_order) {
                $destination_province = $row_order['billing_address']['province_id'];
                $destination_city = $row_order['billing_address']['city_id'];
                //$destination_districts = $row_order['billing_address']['district_id'];
                $destination = $destination_city;
            }

        }

        if($request != null) {
            $kurir_id = Arr::get($request, 'kurir_id');
            $bank_id = Arr::get($request, 'bank_id');
            $metode = 'Transfer';
            $ongkos_kirim = Arr::get($request, 'ongkos');
            $subtotal = Arr::get($request, 'subtotal');
            $total = Arr::get($request, 'total');
            $barang = Arr::get($request, 'barang');
            if(is_array($barang)) {
                $barang = implode(',', $barang);
            }

            if($err_code == 0) {
                if(strlen($kurir_id) == 0) {
                    $err_code = 111;
                    $err_message = "Kurir harus dipilih";
                }
                else if(strlen($bank_id) == 0) {
                    $err_code = 113;
                    $err_message = "Bank harus dipilih";
                }
            }

            if($err_code == 0) {
                try {
                    $shipping_order = array(
                        'barang' => $barang,
                        'courier' => $kurir_id,
                        'bank' => \App\Models\Bank::find($bank_id)->name,
                        'bank_id' => $bank_id,
                        'payment_method' => $metode,
                        'payment_total' => $total,
                    );
                    session()->put('shipping_order', $shipping_order);
                    //
                } catch (\Exception $ex) {
                    $err_code = 1;
                    $err_message = $ex->getMessage();
                }
            }

            if($err_code == 0) {
                return redirect(route('admin.checkout.payment'));
            } else {
                cmsg::add('error', $err_message);
            }
        }

        $data['bank'] = $bank;
        $data['kurir'] = $kurir;
        $data['barang'] = \App\Models\Barang::where('status', '>', 0)->get()->toArray();
        $data['harga'] = $harga;
        $data['origin'] = $origin;
        $data['destination'] = $destination;
        $data['kurir_txt'] = $kurir_txt;
        $data['bank_txt'] = $bank_txt;
        $data['bank_id_txt'] = $bank_id_txt;
        $data['barang_txt'] = $barang_txt;
        $data['payment_method_txt'] = $payment_method_txt;
        $data['payment_total_txt'] = $payment_total_txt;
        $data['title'] = "Checkout - Shipping";
        return view('admin.checkout.shipping', $data);
    }

    public function payment() {
        $errCode = 0;
        $errMsg = '';
        // $ikm_name = '';
        // $ikm_alamat = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        //$checkoutData = \Session::get('checkout_data');
        $project_name = '';
        $project_price = '';
        $project_id = '';
        $transaksi_id = '';
        $transaction_code = '';
        //$transaction_price = '';
        $price = '';
        $price_accept = '';
        $transaction_date = '';
        $name = '';
        $email = '';
        $phone = '';
        $address = '';
        $city_id = '';
        $city_name = '';
        $zipcode = '';
        $province_id = '';
        $province_name = '';
        $kurir = '';
        $barang = '';
        $bank = '';
        $payment_method = '';
        $payment_total = '';
        $penjahit_id = '';

        $transaksiData = self::getDataTransaksi();
        if($transaksiData != null) {
            foreach ($transaksiData as $k => $v):
                $transaksi_id = cobj::get($v, 'id');
                $penjahit_id = cobj::get($v, 'penjahit_id');
                $project_id = cobj::get($v, 'project_id');
                $project_name = cobj::get($v, 'project_name');
                $project_price = cobj::get($v, 'project_price');
                $transaction_code = cobj::get($v, 'code');
                $price = cobj::get($v, 'transaction_price');
                $price_accept = cobj::get($v, 'transaction_total');
                $transaction_date = cobj::get($v, 'transaction_date');
            endforeach;
        }

        $orderData = \Session::get('order_data');
        if($orderData != null) {
            foreach($orderData as $row):
                $province = \App\Models\Province::find($row['billing_address']['province_id']);
                if($province != null) {
                    $province_name = $province->name;
                }

                $city = \App\Models\City::find($row['billing_address']['city_id']);
                if($city != null) {
                    $city_name = $city->name;
                }
                $name = $row['billing_address']['first_name'];
                $email = $row['billing_address']['email'];
                $phone = $row['billing_address']['phone'];
                $address = $row['billing_address']['address'];
                $province_id = $row['billing_address']['province_id'];
                //$province_name = \App\Models\Province::find($row['billing_address']['province_id'])->name;
                $city_id = $row['billing_address']['city_id'];
                //$city_name = \App\Models\City::find($row['billing_address']['city_id'])->name;
                $zipcode = $row['billing_address']['zip_code'];
            endforeach;
        }

        $shippingData = \Session::get('shipping_order');
        if($shippingData != null) {
            $barang = Arr::get($shippingData, 'barang');
            if(is_array($barang)) {
                $barang = implode(",", $barang);
            }
            $kurir = Arr::get($shippingData, 'courier');
            $bank = Arr::get($shippingData, 'bank');
            $payment_method = Arr::get($shippingData, 'payment_method');
            $payment_total = Arr::get($shippingData, 'payment_total');
        }


        if($request != null) {
            try{
                $dataInvoice = array(
                    'transaksi_id'=> $transaksi_id,
                    'project_id'=> $project_id,
                    'ikm_id'=> CUserLogin::get('id'),
                    'penjahit_id'=> '',//$penjahit_id
                    'order_invoice'=> utils::generateInvoice($transaksi_id),
                    'project_name'=> $project_name,
                    'buyer_name'=> $name,
                    'buyer_address'=> $address,
                    'buyer_phone'=> $phone,
                    'buyer_province_id'=> $province_id,
                    'buyer_province_name'=> $province_name,
                    'buyer_city_id'=> $city_id,
                    'buyer_city_name'=> $city_name,
                    'bank'=> $bank,
                    'courier'=> $kurir,
                    'payment_method'=> $payment_method,
                    'payment_total'=> $payment_total,
                    'delivery_progress'=> '',
                    'barang' => $barang,
                    'note'=> ''
                );
                $new_order = new Delivery;
                $new_order->fill($dataInvoice);
                $saved = $new_order->save();
                if($saved) {
                    $penjahit_id = '';
                    $penjahit = \App\Models\Penjahit::where('name', '=', $name)->first();
                    if($penjahit != null) {
                        $penjahit_id = $penjahit->id;
                    }

                    $notif = array(
                        'project_id' => $project_id,
                        'name' => 'Invoice '.$new_order->order_invoice,
                        'description' => 'Project '.$project_name.' telah dilakukan checkout oleh '.CUserLogin::get('name'),
                        'type' => null,
                        'transaksi_id' => $transaksi_id,
                        'penawaran_id' => null,
                        'ikm_id' => CUserLogin::get('id'),
                        'ikm_name' => CUserLogin::get('name'),
                        'penjahit_id' => $penjahit_id,
                        'penjahit_name' => $name,
                    );
                    cnotif::create($notif);

                    //transaksi
                    $transaksi = \App\Models\Transaksi::find($transaksi_id);
                    if($transaksi != null) {
                        $transaksi->update(
                            array(
                                'transaction_total' => $payment_total,
                                'transaction_status' => 'Waited Payment'
                            )
                        );
                    }
                }
            } catch(\Exception $e) {
                $errCode = 14;
                $errMsg = $e->getMessage();
            }

            if($errCode > 0) {
                cmsg::add('error', $errMsg);
            } else {
                cmsg::add('success', 'Your order has been created');
                return redirect(route('admin.transaksi.ikm'));
                //return redirect to view order success;
                //return redirect(route('admin.transaction'));
            }
        }

        $data['project_name'] = $project_name;
        $data['project_price'] =  config('cart.currency')." ".utils::formatCurrency($project_price);
        $data['transaction_code'] = $transaction_code;
        $data['price'] = config('cart.currency')." ".utils::formatCurrency($price);
        $data['price_accept'] = config('cart.currency')." ".utils::formatCurrency($price_accept);
        $data['transaction_date'] = $transaction_date;
        $data['name'] = $name;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['address'] = $address;
        $data['province_id'] = $province_id;
        $data['province_name'] = $province_name;
        $data['city_id'] = $city_id;
        $data['city_name'] = $city_name;
        $data['zipcode'] = $zipcode;
        $data['barang'] = $barang;
        $data['kurir'] = $kurir;
        $data['bank'] = $bank;
        $data['payment_method'] = $payment_method;
        $data['payment_total'] = config('cart.currency')." ".utils::formatCurrency($payment_total);
        // $data['transaksi'] = $transaksiData;
        // $data['shipping'] = $shippingData;
        // $data['order'] = $orderData;
        $data['title'] = "Checkout - Payment";
        return view('admin.checkout.payment', $data);
    }


    public static function getDataTransaksi() {
        $transaksiId = \Session::get('transaksi_id');
        $q = "
            SELECT
                t.id,
                t.name,
                t.penjahit_id,
                p.id as project_id,
                p.name as project_name,
                p.price as project_price,
                t.code,
                t.transaction_price,
                t.transaction_total,
                t.transaction_date
            FROM transaction t
            JOIN project p ON t.project_id = p.id
            WHERE t.id = '{$transaksiId}'
        ";
        $result = \DB::select(\DB::raw($q));
        return $result;
    }
}