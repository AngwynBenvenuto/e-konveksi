<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Lintas\libraries\CMember;
use Lintas\libraries\CData;
use Lintas\libraries\CMemberLogin;
use Lintas\helpers\cdbutils;
use Lintas\helpers\utils;
use Lintas\helpers\carr;
use Lintas\helpers\cobj;
use Lintas\helpers\cmsg;
use Lintas\helpers\cnotif;
use Illuminate\Support\Arr;
use App\Models\Delivery;

class CheckoutController extends Controller
{

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
        //$billing_districts_id = '';
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
        //$shipping_districts_id = '';
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

        //if(strlen(CMemberLogin::get('id')) > 0)  {
            // $data['member_id'] = CMemberLogin::get('id');

            // try {
            //     $data['list_address'] = CMember::getListMemberAddress($data);
            //     foreach ($data['list_address'] as $key => $value) {
            //         if ($key == 0) {
            //             $billing_address = $data['list_address'][$key]['billing'];
            //         }
            //         if ($key == 1) {
            //             $shipping_address = $data['list_address'][$key]['shipping'];
            //         }
            //     }
            //     if (!empty($billing_address)) {
            //         $data['billing_address'] = $billing_address;
            //     }
            //     if (!empty($shipping_address)) {
            //         $data['shipping_address'] = $shipping_address;
            //     }
            //     if (!empty($billing_address) && !empty($shipping_address)) {
            //         $data['address'] = array_merge($billing_address, $shipping_address);
            //         session()->put('address', $data['address']);
            //     }
            // } catch (\Exception $ex) {
            //     $err_code++;
            //     $err_message = $ex->getMessage();
            // }

            if ($err_code == 0 && $request != null) {
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
                // $billing = Arr::get($request, 'billing_member_address_id');
                // $shipping = Arr::get($request,'shipping_member_address_id');
                // $address = \Session::get('address');

                // if($address != null) {
                //     foreach ($address as $value) {
                //         if ($value['penjahit_address_id'] == $billing) {
                //             $billing_province_id = Arr::get($value, 'province_id');
                //             $billing_city_id = Arr::get($value, 'city_id');
                //             $billing_districts_id = Arr::get($value, 'districts_id');
                //             $billing_name = Arr::get($value, 'name');
                //             $billing_email = Arr::get($value, 'email');
                //             $billing_phone = Arr::get($value, 'phone');
                //             $billing_zipcode = Arr::get($value, 'postal');
                //             $billing_address = Arr::get($value, 'address');
                //             $billing_country_id = Arr::get($value, 'country_id');
                //             $billing_city_name = Arr::get($value, 'city_name');
                //             $billing_province_name = Arr::get($value, 'province_name');
                //             $billing_districts_name = Arr::get($value, 'district_name');
                //             $billing_lat = Arr::get($value, 'lat');
                //             $billing_long = Arr::get($value, 'long');
                //         }

                //         if ($value['penjahit_address_id'] == $shipping) {
                //             $shipping_province_id = Arr::get($value, 'province_id');
                //             $shipping_city_id = Arr::get($value, 'city_id');
                //             $shipping_districts_id = Arr::get($value, 'districts_id');
                //             $shipping_name = Arr::get($value, 'name');
                //             $shipping_email = Arr::get($value, 'email');
                //             $shipping_phone = Arr::get($value, 'phone');
                //             $shipping_zipcode = Arr::get($value, 'postal');
                //             $shipping_address = Arr::get($value, 'address');
                //             $shipping_country_id = Arr::get($value, 'country_id');
                //             $shipping_city_name = Arr::get($value, 'city_name');
                //             $shipping_province_name = Arr::get($value, 'province_name');
                //             $shipping_districts_name = Arr::get($value, 'district_name');
                //             $shipping_lat = Arr::get($value, 'lat');
                //             $shipping_long = Arr::get($value, 'long');
                //             // $shipping_courier = Arr::get($extracted, 'shipping_courier');
                //             // $shipping_service = Arr::get($extracted, 'shipping_service');
                //         }
                //     }

                //     if ($err_code == 0) {
                //         $default_country = 'Indonesia';
                //         $default_province = 'Jakarta';
                //         $default_city = 'Jakarta';

                //         $country_code = cdbutils::get_value("select code from country where name like '%" . ($default_country) . "%' ");
                //         $order_data = array();

                //         //carr::set_path($order_data, 'transaksi.id', $transaksi_id);
                //         carr::set_path($order_data, 'contact_detail.billing_address.first_name', $billing_name);
                //         carr::set_path($order_data, 'contact_detail.billing_address.email', $billing_email);
                //         carr::set_path($order_data, 'contact_detail.billing_address.phone', $billing_phone);
                //         carr::set_path($order_data, 'contact_detail.billing_address.address', $billing_address);
                //         carr::set_path($order_data, 'contact_detail.billing_address.province_id', $billing_province_id);
                //         carr::set_path($order_data, 'contact_detail.billing_address.city_id', $billing_city_id);
                //         carr::set_path($order_data, 'contact_detail.billing_address.district_id', $billing_districts_id);
                //         carr::set_path($order_data, 'contact_detail.billing_address.zip_code', $billing_zipcode);
                //         carr::set_path($order_data, 'contact_detail.billing_address.postal_code', $billing_zipcode);
                //         $billingProvinceRecord = CData::getProvince(array('province_id' => $billing_province_id));
                //         carr::set_path($order_data, 'contact_detail.billing_address.province_name', $billing_province_name);
                //         carr::set_path($order_data, 'contact_detail.billing_address.province', $billing_province_name);
                //         $billingCityRecord = CData::getCity(array('city_id' => $billing_city_id));
                //         carr::set_path($order_data, 'contact_detail.billing_address.city_name', $billing_city_name);
                //         carr::set_path($order_data, 'contact_detail.billing_address.city', $billing_city_name);
                //         $billingDistrictsRecord = CData::getDistricts(array('districts_id' => $billing_districts_id));
                //         carr::set_path($order_data, 'contact_detail.billing_address.district_name', $billing_districts_name);
                //         carr::set_path($order_data, 'contact_detail.billing_address.district', $billing_districts_name);
                //         carr::set_path($order_data, 'contact_detail.billing_address.country_code', $country_code);
                //         carr::set_path($order_data, 'contact_detail.billing_address.lat', $billing_lat);
                //         carr::set_path($order_data, 'contact_detail.billing_address.long', $billing_long);

                //         carr::set_path($order_data, 'contact_detail.shipping_address.first_name', $shipping_name);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.email', $shipping_email);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.phone', $shipping_phone);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.address', $shipping_address);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.province_id', $shipping_province_id);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.city_id', $shipping_city_id);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.district_id', $shipping_districts_id);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.zip_code', $shipping_zipcode);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.postal_code', $shipping_zipcode);
                //         $shippingProvinceRecord = CData::getProvince(array('province_id' => $shipping_province_id));
                //         carr::set_path($order_data, 'contact_detail.shipping_address.province_name', $shipping_province_name);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.province', $shipping_province_name);
                //         $shippingCityRecord = CData::getCity(array('city_id' => $shipping_city_id));
                //         carr::set_path($order_data, 'contact_detail.shipping_address.city_name', $shipping_city_name);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.city', $shipping_city_name);
                //         $shippingDistrictsRecord = CData::getDistricts(array('districts_id' => $shipping_districts_id));
                //         carr::set_path($order_data, 'contact_detail.shipping_address.district_name', $shipping_districts_name);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.district', $shipping_districts_name);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.country_code', $country_code);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.lat', $shipping_lat);
                //         carr::set_path($order_data, 'contact_detail.shipping_address.long', $shipping_long);

                //         session()->put('order_data', $order_data);
                //         $items = array();

                //         //checkout
                //         $options = array(
                //             "destination_city_id" => $shipping_city_id,
                //             "destination_district_id" => $shipping_districts_id,
                //             "destination_lat" => $shipping_lat,
                //             "destination_long" => $shipping_long,
                //             "member_id" => CMemberLogin::get('id'),
                //             "item" => $items
                //         );
                //         //set checkout
                //     }
                // } else {
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
                    //$billing_districts_name = Arr::get($request, 'billing_district_name');
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
                    //$shipping_districts_name = Arr::get($request, 'shipping_district_name');
                    $shipping_lat = Arr::get($request, 'shipping_lat');
                    $shipping_long = Arr::get($request, 'shipping_long');

                    if($err_code == 0){
                        if(strlen($billing_name) == 0) {
                            $err_code = 134;
                            $err_message = "Name Required";
                        }
                        else if(strlen($billing_email) == 0) {
                            $err_code = 134;
                            $err_message = "Email Required";
                        }
                        else if(strlen($billing_phone) == 0) {
                            $err_code = 134;
                            $err_message = "Phone Required";
                        }
                        else if(strlen($billing_province_id) == 0) {
                            $err_code = 134;
                            $err_message = "Province Required";
                        }
                        else if(strlen($billing_city_id) == 0) {
                            $err_code = 134;
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
                            //$billing_districts_id = $shipping_districts_id;
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
                        //carr::set_path($order_data, 'contact_detail.billing_address.district_id', $billing_districts_id);
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
                        //carr::set_path($order_data, 'contact_detail.shipping_address.district_id', $shipping_districts_id);
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
                //}

                if ($err_code == 0) {
                    return redirect(route('checkout.shipping'));
                } else {
                    cmsg::add('error', $err_message);
                }
            }
        //}
        // else {
        //     $default_country = 'Indonesia';
        //     $default_province = 'Jakarta';
        //     $default_city = 'Jakarta';

        //     $country_code = cdbutils::get_value("select code from country where name like '%" .($default_country). "%' ");
        //     $country_id = cdbutils::get_value("select id from country where name like '%" .($default_country). "%' ");
        //     $province_id = cdbutils::get_value("select id from province where country_id=" .($country_id). " and name like '%" .($default_province). "%' ");
        //     $city_id = cdbutils::get_value("select city_id from city where province_id=" .($province_id). " and name like '%" .($default_city). "%' ");
        //     $districts_id = cdbutils::get_value("select districts_id from districts where city_id=".($city_id). "");

        //     $billing_country_id = $country_id;
        //     $billing_province_id = $province_id;
        //     $billing_city_id = $city_id;
        //     $billing_districts_id = $districts_id;
        //     $billing_name = '';
        //     $billing_email = '';
        //     $billing_phone = '';
        //     $billing_address = '';
        //     $billing_zipcode = '';
        //     $billing_lat = '';
        //     $billing_long = '';

        //     $same_billing_address = false;

        //     $shipping_country_id = $country_id;
        //     $shipping_province_id = $province_id;
        //     $shipping_city_id = $city_id;
        //     $shipping_districts_id = $districts_id;
        //     $shipping_name = '';
        //     $shipping_email = '';
        //     $shipping_phone = '';
        //     $shipping_address = '';
        //     $shipping_zipcode = '';
        //     $shipping_lat = '';
        //     $shipping_long = '';
        //     $shipping_courier = '';

        //     if (strlen(CMemberLogin::get('id')) > 0) {
        //         $param = array();
        //         $param['member_id'] = CMemberLogin::get('id');
        //         try {
        //             $addresses = CMember::getListMemberAddress($param);
        //         } catch (Api_Exception $ex) {
        //             $err_code++;
        //             $err_message = $ex->getMessage();
        //         } catch (\Exception $ex) {
        //             $err_code++;
        //             $err_message = '[FATAL ERROR] ' . $ex->getMessage();
        //         }


        //         if ($err_code > 0) {
        //             cmsg::add('error', $err_message);
        //         }

        //         if ($err_code == 0) {
        //             $billing_addresses = Arr::get($addresses, 'billing', array());
        //             $shipping_addresses = Arr::get($addresses, 'shipping', array());
        //             foreach ($billing_addresses as $address) {
        //                 if (Arr::get($address, 'is_main_address')) {
        //                     $billing_country_id = Arr::get($address, 'country_id');
        //                     $billing_province_id = Arr::get($address, 'province_id');
        //                     $billing_city_id = Arr::get($address, 'city_id');
        //                     $billing_districts_id = Arr::get($address, 'districts_id');
        //                     $billing_name = Arr::get($address, 'name');
        //                     $billing_email = Arr::get($address, 'email');
        //                     $billing_phone = Arr::get($address, 'phone');
        //                     $billing_address = Arr::get($address, 'address');
        //                     $billing_zipcode = Arr::get($address, 'postal');
        //                     $billing_lat = Arr::get($address, 'lat');
        //                     $billing_long = Arr::get($address, 'long');
        //                 }
        //             }

        //             foreach ($shipping_addresses as $address) {
        //                 if (Arr::get($address, 'is_main_address')) {
        //                     $shipping_country_id = Arr::get($address, 'country_id');
        //                     $shipping_province_id = Arr::get($address, 'province_id');
        //                     $shipping_city_id = Arr::get($address, 'city_id');
        //                     $shipping_districts_id = Arr::get($address, 'districts_id');
        //                     $shipping_name = Arr::get($address, 'name');
        //                     $shipping_email = Arr::get($address, 'email');
        //                     $shipping_phone = Arr::get($address, 'phone');
        //                     $shipping_address = Arr::get($address, 'address');
        //                     $shipping_zipcode = Arr::get($address, 'postal');
        //                     $shipping_lat = Arr::get($address, 'lat');
        //                     $shipping_long = Arr::get($address, 'long');
        //                 }
        //             }
        //         }
        //     }

        //     if ($err_code == 0) {
        //         $order_data = \Session::get('order_data');
        //         if (isset($order_data['contact_detail'])) {
        //             $billing_name = carr::path($order_data, 'contact_detail.billing_address.first_name');
        //             $billing_email = carr::path($order_data, 'contact_detail.billing_address.email');
        //             $billing_phone = carr::path($order_data, 'contact_detail.billing_address.phone');
        //             $billing_address = carr::path($order_data, 'contact_detail.billing_address.address');
        //             $billing_province_id = carr::path($order_data, 'contact_detail.billing_address.province_id');
        //             $billing_province_name = carr::path($order_data, 'contact_detail.billing_address.province_name');
        //             $billing_city_id = carr::path($order_data, 'contact_detail.billing_address.city_id');
        //             $billing_city_name = carr::path($order_data, 'contact_detail.billing_address.city_name');
        //             $billing_districts_id = carr::path($order_data, 'contact_detail.billing_address.district_id');
        //             $billing_districts_name = carr::path($order_data, 'contact_detail.billing_address.district_name');
        //             $billing_zipcode = carr::path($order_data, 'contact_detail.billing_address.zip_code');
        //             $billing_lat = carr::path($order_data, 'contact_detail.billing_address.lat');
        //             $billing_long = carr::path($order_data, 'contact_detail.billing_address.long');

        //             $shipping_name = carr::path($order_data, 'contact_detail.shipping_address.first_name');
        //             $shipping_email = carr::path($order_data, 'contact_detail.shipping_address.email');
        //             $shipping_phone = carr::path($order_data, 'contact_detail.shipping_address.phone');
        //             $shipping_address = carr::path($order_data, 'contact_detail.shipping_address.address');
        //             $shipping_province_id = carr::path($order_data, 'contact_detail.shipping_address.province_id');
        //             $shipping_province_name = carr::path($order_data, 'contact_detail.shipping_address.province_name');
        //             $shipping_city_id = carr::path($order_data, 'contact_detail.shipping_address.city_id');
        //             $shipping_city_name = carr::path($order_data, 'contact_detail.shipping_address.city_name');
        //             $shipping_districts_id = carr::path($order_data, 'contact_detail.shipping_address.district_id');
        //             $shipping_districts_name = carr::path($order_data, 'contact_detail.shipping_address.district_name');
        //             $shipping_zipcode = carr::path($order_data, 'contact_detail.shipping_address.zip_code');
        //             $shipping_lat = carr::path($order_data, 'contact_detail.shipping_address.lat');
        //             $shipping_long = carr::path($order_data, 'contact_detail.shipping_address.long');
        //         }
        //     }

        //     if ($err_code == 0 && $request != null) {
        //         $keys = array(
        //             'billing_province_id', 'billing_city_id', 'billing_districts_id', 'billing_name'
        //             , 'billing_email', 'billing_phone', 'billing_zipcode', 'billing_address'
        //             , 'billing_lat', 'billing_long'
        //             , 'shipping_province_id', 'shipping_city_id', 'shipping_districts_id', 'shipping_name'
        //             , 'shipping_email', 'shipping_phone', 'shipping_zipcode', 'shipping_address'
        //             , 'shipping_lat', 'shipping_long'
        //             , 'shipping_courier', 'shipping_service'
        //             , 'latlng'
        //         );
        //         $extracted = carr::extract($request, $keys);
        //         $same_billing_address = Arr::get($request, 'same_billing_address', false);
        //         if ($same_billing_address) {
        //             $extracted['billing_name'] = $extracted['shipping_name'];
        //             $extracted['billing_email'] = $extracted['shipping_email'];
        //             $extracted['billing_phone'] = $extracted['shipping_phone'];
        //             $extracted['billing_address'] = $extracted['shipping_address'];
        //             $extracted['billing_province_id'] = $extracted['shipping_province_id'];
        //             $extracted['billing_city_id'] = $extracted['shipping_city_id'];
        //             $extracted['billing_districts_id'] = $extracted['shipping_districts_id'];
        //             $extracted['billing_zipcode'] = $extracted['shipping_zipcode'];
        //         }
        //         $billing_province_id = Arr::get($extracted, 'billing_province_id');
        //         $billing_city_id = Arr::get($extracted, 'billing_city_id');
        //         $billing_districts_id = Arr::get($extracted, 'billing_districts_id');
        //         $billing_name = Arr::get($extracted, 'billing_name');
        //         $billing_email = Arr::get($extracted, 'billing_email');
        //         $billing_phone = Arr::get($extracted, 'billing_phone');
        //         $billing_zipcode = Arr::get($extracted, 'billing_zipcode');
        //         $billing_address = Arr::get($extracted, 'billing_address');
        //         $billing_lat = Arr::get($extracted, 'billing_lat');
        //         $billing_long = Arr::get($extracted, 'billing_long');

        //         $shipping_province_id = Arr::get($extracted, 'shipping_province_id');
        //         $shipping_city_id = Arr::get($extracted, 'shipping_city_id');
        //         $shipping_districts_id = Arr::get($extracted, 'shipping_districts_id');
        //         $shipping_name = Arr::get($extracted, 'shipping_name');
        //         $shipping_email = Arr::get($extracted, 'shipping_email');
        //         $shipping_phone = Arr::get($extracted, 'shipping_phone');
        //         $shipping_zipcode = Arr::get($extracted, 'shipping_zipcode');
        //         $shipping_address = Arr::get($extracted, 'shipping_address');
        //         $shipping_lat = Arr::get($extracted, 'shipping_lat');
        //         $shipping_long = Arr::get($extracted, 'shipping_long');

        //         $shipping_courier = Arr::get($extracted, 'shipping_courier');
        //         $shipping_service = Arr::get($extracted, 'shipping_service');

        //         if($err_code == 0) {
        //             $latlng = explode(',', Arr::get($extracted, 'latlng'));
        //             $shipping_lat = Arr::get($latlng, 0);
        //             $shipping_long = Arr::get($latlng, 1);

        //             $order_data = array();
        //             //carr::set_path($order_data, 'transaksi.id', $transaksi_id);
        //             carr::set_path($order_data, 'contact_detail.billing_address.first_name', $billing_name);
        //             carr::set_path($order_data, 'contact_detail.billing_address.email', $billing_email);
        //             carr::set_path($order_data, 'contact_detail.billing_address.phone', $billing_phone);
        //             carr::set_path($order_data, 'contact_detail.billing_address.address', $billing_address);
        //             carr::set_path($order_data, 'contact_detail.billing_address.province_id', $billing_province_id);
        //             carr::set_path($order_data, 'contact_detail.billing_address.city_id', $billing_city_id);
        //             carr::set_path($order_data, 'contact_detail.billing_address.district_id', $billing_districts_id);
        //             carr::set_path($order_data, 'contact_detail.billing_address.zip_code', $billing_zipcode);
        //             carr::set_path($order_data, 'contact_detail.billing_address.postal_code', $billing_zipcode);
        //             $billingProvinceRecord = CData::getProvince(array('province_id' => $billing_province_id));
        //             carr::set_path($order_data, 'contact_detail.billing_address.province_name', $billing_province_name);
        //             carr::set_path($order_data, 'contact_detail.billing_address.province', $billing_province_name);
        //             $billingCityRecord = CData::getCity(array('city_id' => $billing_city_id));
        //             carr::set_path($order_data, 'contact_detail.billing_address.city_name', $billing_city_name);
        //             carr::set_path($order_data, 'contact_detail.billing_address.city', $billing_city_name);
        //             $billingDistrictsRecord = CData::getDistricts(array('districts_id' => $billing_districts_id));
        //             carr::set_path($order_data, 'contact_detail.billing_address.district_name', $billing_districts_name);
        //             carr::set_path($order_data, 'contact_detail.billing_address.district', $billing_districts_name);
        //             carr::set_path($order_data, 'contact_detail.billing_address.country_code', $country_code);
        //             carr::set_path($order_data, 'contact_detail.billing_address.lat', $billing_lat);
        //             carr::set_path($order_data, 'contact_detail.billing_address.long', $billing_long);

        //             carr::set_path($order_data, 'contact_detail.shipping_address.first_name', $shipping_name);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.email', $shipping_email);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.phone', $shipping_phone);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.address', $shipping_address);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.province_id', $shipping_province_id);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.city_id', $shipping_city_id);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.district_id', $shipping_districts_id);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.zip_code', $shipping_zipcode);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.postal_code', $shipping_zipcode);
        //             $shippingProvinceRecord = CData::getProvince(array('province_id' => $shipping_province_id));
        //             carr::set_path($order_data, 'contact_detail.shipping_address.province_name', $shipping_province_name);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.province', $shipping_province_name);
        //             $shippingCityRecord = CData::getCity(array('city_id' => $shipping_city_id));
        //             carr::set_path($order_data, 'contact_detail.shipping_address.city_name', $shipping_city_name);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.city', $shipping_city_name);
        //             $shippingDistrictsRecord = CData::getDistricts(array('districts_id' => $shipping_districts_id));
        //             carr::set_path($order_data, 'contact_detail.shipping_address.district_name', $shipping_districts_name);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.district', $shipping_districts_name);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.country_code', $country_code);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.lat', $shipping_lat);
        //             carr::set_path($order_data, 'contact_detail.shipping_address.long', $shipping_long);

        //             session()->put('order_data', $order_data);
        //             $items = array();

        //             //checkout
        //             $options = array(
        //                 "destination_city_id" => $shipping_city_id,
        //                 "destination_district_id" => $shipping_districts_id,
        //                 "destination_lat" => $shipping_lat,
        //                 "destination_long" => $shipping_long,
        //                 "member_id" => CMemberLogin::get('id'),
        //                 "item" => $items
        //             );
        //             //set checkout
        //         }

        //         if ($err_code == 0) {
        //             return redirect(route('checkout.shipping'));
        //         } else {
        //             cmsg::add('error', $err_message);
        //         }
        //     }
        //}

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
        return view('front.checkout.address', $data);
    }

    public function shipping() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        //$bank = \App\Models\Bank::where('status','>',0)->whereIn('name', array('BCA','MANDIRI','BNI','BRI'))->get()->toArray();
        //$orderData = \Session::get('order_data');
        $kurir =\App\Models\DeliveryService::where('status','>', 0)->whereIn('name', array('JNE', 'POS', 'TIKI'))->get()->toArray();
        $project = '';
        $harga = '';
        $destination = '';
        $origin = CMemberLogin::get('city_id');

        $kurir_txt = '';
        //$bank_txt = '';
        //$bank_id_txt = '';
        $barang_txt = '';
        $payment_method_txt = '';
        $payment_total_txt = '';
        $shippingOrder = \Session::get('shipping_order');
        if($shippingOrder != null) {
            $kurir_txt = Arr::get($shippingOrder, 'courier');
            $bank_id_txt = Arr::get($shippingOrder, 'bank_id');
            //$bank_txt = Arr::get($shippingOrder, 'bank');
            $barang_txt = Arr::get($shippingOrder, 'barang');
            $payment_method_txt = Arr::get($shippingOrder, 'payment_method');
            $payment_total_txt = Arr::get($shippingOrder, 'payment_total');
        }

        $transaksi = self::getDataTransaksi();
        if($transaksi != null) {
            foreach($transaksi as $key => $value) {
                $project = cobj::get($value, 'project_name');
                $code = cobj::get($value, 'code');
                $harga = cobj::get($value, 'transaction_total');
            }
        }

        $orderData = \Session::get('order_data');
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
            //$bank_id = Arr::get($request, 'bank_id');
            //$metode = 'Transfer';
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
                // else if(strlen($bank_id) == 0) {
                //     $err_code = 113;
                //     $err_message = "Bank harus dipilih";
                // }
            }

            if($err_code == 0) {
                try {
                    $shipping_order = array(
                        'barang' => $barang,
                        'courier' => $kurir_id,
                        //'bank' => \App\Models\Bank::find($bank_id)->name,
                        //'bank_id' => $bank_id,
                        //'payment_method' => $metode,
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
                return redirect(route('checkout.payment'));
            } else {
                cmsg::add('error', $err_message);
            }
        }

        //$data['bank'] = $bank;
        $data['kurir'] = $kurir;
        $data['barang'] = \App\Models\Barang::where('status', '>', 0)->get()->toArray();
        $data['harga'] = $harga;
        $data['origin'] = $origin;
        $data['destination'] = $destination;
        $data['kurir_txt'] = $kurir_txt;
        //$data['bank_txt'] = $bank_txt;
        //$data['bank_id_txt'] = $bank_id_txt;
        $data['barang_txt'] = $barang_txt;
        $data['payment_method_txt'] = $payment_method_txt;
        $data['payment_total_txt'] = $payment_total_txt;
        $data['title'] = "Checkout - Shipping";
        return view('front.checkout.shipping', $data);
    }

    public function payment() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $project_name = '';
        $project_id = '';
        $project_price = '';
        $transaksi_id = '';
        $transaction_code = '';
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
        $bank = '';
        $payment_method = '';
        $payment_total = '';
        $ikm_id = '';

        $transaksiData = self::getDataTransaksi();
        if($transaksiData != null) {
            foreach ($transaksiData as $k => $v):
                $transaksi_id = cobj::get($v, 'id');
                $ikm_id = cobj::get($v, 'ikm_id');
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
                //$province_name = ;
                $city_id = $row['billing_address']['city_id'];
                //$city_name = \App\Models\City::find($row['billing_address']['city_id'])->name;
                $zipcode = $row['billing_address']['zip_code'];
            endforeach;
        }

        $shippingData = \Session::get('shipping_order');
        if($shippingData != null) {
            $kurir = Arr::get($shippingData, 'courier');
            $bank = Arr::get($shippingData, 'bank');
            $barang = Arr::get($shippingData, 'barang');
            if(is_array($barang)) {
                $barang = implode(",", $barang);
            }
            $payment_method = Arr::get($shippingData, 'payment_method');
            $payment_total = Arr::get($shippingData, 'payment_total');
        }


        if($request != null) {
            try{
                $dataInvoice = array(
                    'transaksi_id'=> $transaksi_id,
                    'project_id'=> $project_id,
                    'ikm_id'=> '',//$ikm_id
                    'penjahit_id' => CMemberLogin::get('id'),
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
                    'note' => ''
                    //'note'=> 'Barang yang dikirim '.$barang
                );
                $new_order = new Delivery;
                $new_order->fill($dataInvoice);
                $saved = $new_order->save();
                if($saved) {
                    $ikm_id = '';
                    $ikm = \App\Models\Ikm::where('name', '=', $name)->first();
                    if($ikm != null) {
                        $ikm_id = $ikm->id;
                    }

                    $notif = array(
                        'project_id' => $project_id,
                        'name' => 'Invoice '.$new_order->order_invoice,
                        'description' => 'Project '.$project_name.' telah dilakukan checkout oleh '. CMemberLogin::get('name'),
                        'type' => null,
                        'transaksi_id' => $transaksi_id,
                        'penawaran_id' => null,
                        'ikm_id' => $ikm_id,
                        'ikm_name' => $name,
                        'penjahit_id' => CMemberLogin::get('id'),
                        'penjahit_name' => CMemberLogin::get('name'),
                    );
                    cnotif::create($notif);

                    //transaksi
                    $transaksi = \App\Models\Transaksi::find($transaksi_id);
                    if($transaksi != null) {
                        $transaksi->update(
                            array(
                                'transaction_total' => $payment_total,
                                'transaction_status' => 'Waited Confirmation'
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
                return redirect(route('transaction.list'));
                //return redirect to view order success;
            }
        }

        $data['project_name'] = $project_name;
        $data['project_price'] = config('cart.currency')." ".utils::formatCurrency($project_price);
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
        $data['kurir'] = $kurir;
        $data['bank'] = $bank;
        $data['payment_method'] = $payment_method;
        $data['payment_total'] = config('cart.currency')." ".utils::formatCurrency($payment_total);
        // $data['transaksi'] = $transaksiData;
        // $data['shipping'] = $shippingData;
        // $data['order'] = $orderData;
        $data['title'] = "Checkout - Payment";
        return view('front.checkout.payment', $data);
    }


    public static function getDataTransaksi() {
        $transaksiId = \Session::get('transaksi_id');
        $q = "
            SELECT
                t.id,
                t.name,
                t.ikm_id,
                p.id as project_id,
                p.name as project_name,
                p.price as project_price,
                t.code,
                t.transaction_total,
                t.transaction_price,
                t.transaction_date
            FROM transaction t
            JOIN project p ON t.project_id = p.id
            WHERE t.id = '{$transaksiId}'
        ";
        $result = \DB::select(\DB::raw($q));
        return $result;
    }
}
