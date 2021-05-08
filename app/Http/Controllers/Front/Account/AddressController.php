<?php

namespace App\Http\Controllers\Front\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Auth, DB;
use Lintas\helpers\cdbutils;
use Lintas\helpers\cmsg;
use Lintas\libraries\CData;
use Lintas\libraries\CMember;
use Lintas\libraries\CApi\Exception as ApiException;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $errCode = 0;
        $errMessage = '';
        $user = Auth::check() ? Auth::user() : array();
        $param = array();
        $param['member_id'] = $user->id;
        $result = null;
        $data = array();
        try {
            $result = CMember::getListMemberAddress($param);
        } catch (ApiException $ex) {
            $errCode++;
            $errMessage = $ex->getMessage();
        } catch (\Exception $ex) {
            $errCode++;
            $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
        }

        if ($errCode > 0) {
            cmsg::add('error', $errMessage);
        }

        if ($result == null) {
            $result = array();
        }

        $data['addresses'] = $result;
        return view('front.user.address', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return $this->edit();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($billingAddressId = '', $shippingAddressId = '') {
        $data = array();

        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMessage = '';
        $user = Auth::check() ? Auth::user() : array();

        $fromCheckout = false;
        if (isset($_GET['ref'])) {
            $ref = $_GET['ref'];
            if ($ref == 'checkout') {
                $fromCheckout = true;
            }
        }

        $default_country_name = 'Indonesia';
        $default_province_name = 'Jakarta';
        $default_city_name = 'Jakarta';
       
        $default_country_id = cdbutils::get_value("select id from country where name like '%" . ($default_country_name) . "%' ");
        $country_id = 94;
        if ($country_id != $default_country_id) {
            $default_province_name = '';
            $default_city_name = '';
            $default_province = cdbutils::get_row("select province_id,name from province where country_id=".($country_id));
            if ($default_province != null) {
                $default_province_id = $default_province->province_id;
                $default_province_name = $default_province->name;
            }
            if (strlen($default_province_id) > 0) {
                $default_city = cdbutils::get_row("select city_id,name from city where province_id=".($default_province_id));
                if ($default_city != null) {
                    $default_city_id = $default_city->city_id;
                    $default_city_name = $default_city->name;
                }
            }
        }

        $billingProvinceId = cdbutils::get_value("select id from province where name like '%".$default_province_name."%'");
        $whereBillingProvince = "";
        if(strlen($billingProvinceId) > 0)
            $whereBillingProvince .= " and province_id=".($billingProvinceId)." ";
        $queryBillingCity = "select id from city where name like '%".($default_city_name)."%' $whereBillingProvince";
        $billingCityId = cdbutils::get_value($queryBillingCity);
        $billingDistrictsId = "";    
        $billingName = '';
        $billingEmail = $user->email;
        $billingPhone = '';
        $billingZipcode = '';
        $billingAddress = '';

        $shippingProvinceId = cdbutils::get_value("select id from province where name like '%" .($default_province_name) . "%' ");
        $whereShippingProvince = "";
        if(strlen($shippingProvinceId) > 0) 
            $whereShippingProvince .= " and province_id=" . ($shippingProvinceId) . " ";
        $queryShippingProvince = "select id from city where name like '%" .($default_city_name) . "%' $whereShippingProvince";
        $shippingCityId = cdbutils::get_value($queryShippingProvince);
        $shippingDistrictsId = "";
        $shippingName = '';
        $shippingEmail = $user->email;
        $shippingPhone = '';
        $shippingZipcode = '';
        $shippingAddress = '';
        
        if (strlen($billingAddressId) > 0) {
            $param = array();
            $param['member_id'] = $user->id;
            $param['member_address_id'] = $billingAddressId;
            $param['type'] = 'billing';
            try {
                $result = CMember::getMemberAddressType($param);
                $billingName = Arr::get($result, 'name');
                $billingPhone = Arr::get($result, 'phone');
                $billingAddress = Arr::get($result, 'address');
                $billingZipcode = Arr::get($result, 'postal');
                $billingEmail = Arr::get($result, 'email');
                $billingProvinceId = Arr::get($result, 'province_id');
                $billingCityId = Arr::get($result, 'city_id');
                $billingDistrictsId = Arr::get($result, 'districts_id');
            } catch (ApiException $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            } catch (\Exception $e) {
                $errCode++;
                $errMessage = $e->getMessage();
            }

            if ($errCode > 0) {
                cmsg::add('error', $errMessage);
            }

        }

        if (strlen($shippingAddressId) > 0) {
            $param = array();
            $param['member_id'] = $user->id;
            $param['member_address_id'] = $shippingAddressId;
            $param['type'] = 'shipping';
            try {
                $result = CMember::getMemberAddressType($param);
                $shippingName = Arr::get($result, 'name');
                $shippingPhone = Arr::get($result, 'phone');
                $shippingAddress = Arr::get($result, 'address');
                $shippingZipcode = Arr::get($result, 'postal');
                $shippingEmail = Arr::get($result, 'email');
                $shippingProvinceId = Arr::get($result, 'province_id');
                $shippingCityId = Arr::get($result, 'city_id');
                $shippingDistrictsId = Arr::get($result, 'districts_id');
            } catch (ApiException $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            } catch (\Exception $e) {
                $errCode++;
                $errMessage = $e->getMessage();
            }

            if ($errCode > 0) {
                cmsg::add('error', $errMessage);
            }
        }

        if ($request != null) {
            $sameBillingAddress = Arr::get($request, 'same_billing_address', 0);
            $billingProvinceId = Arr::get($request, 'billing_province_id', Arr::get($request, 'shipping_province_id'));
            $billingCityId = Arr::get($request, 'billing_city_id', Arr::get($request, 'shipping_city_id'));
            if ($sameBillingAddress) {
                $billingProvinceId = Arr::get($request, 'shipping_province_id');
                $billingCityId = Arr::get($request, 'shipping_city_id');
                $billingDistrictsId = Arr::get($request, 'shipping_districts_id');
            }
            $billingDistrictsId = Arr::get($request, 'billing_districts_id');
            $billingName = Arr::get($request, 'billing_name');
            $billingEmail = Arr::get($request, 'billing_email');
            $billingPhone = Arr::get($request, 'billing_phone');
            $billingZipcode = Arr::get($request, 'billing_zipcode');
            $billingAddress = Arr::get($request, 'billing_address');

            $shippingProvinceId = Arr::get($request, 'shipping_province_id');
            $shippingCityId = Arr::get($request, 'shipping_city_id');
            $shippingDistrictsId = Arr::get($request, 'shipping_districts_id');
            $shippingName = Arr::get($request, 'shipping_name');
            $shippingEmail = Arr::get($request, 'shipping_email');
            $shippingPhone = Arr::get($request, 'shipping_phone');
            $shippingZipcode = Arr::get($request, 'shipping_zipcode');
            $shippingAddress = Arr::get($request, 'shipping_address');

            if ($errCode == 0) {
                if (strlen($shippingName) == 0) {
                    $errCode = 134;
                    $errMessage = 'Shipping name required';
                }
            }
            if ($errCode == 0) {
                if (strlen($shippingEmail) == 0) {
                    $errCode = 135;
                    $errMessage = 'Shipping email required';
                }
            }
            if ($errCode == 0) {
                if (strlen($shippingPhone) == 0) {
                    $errCode= 136;
                    $errMessage = 'Shipping phone required';
                }
            }

            if ($errCode == 0) {
                if (strlen($billingName) == 0) {
                    $errCode= 137;
                    $errMessage = 'Billing name required';
                }
            }
            if ($errCode == 0) {
                if (strlen($billingEmail) == 0) {
                    $errCode= 138;
                    $errMessage = 'Billing email required';
                }
            }
            if ($errCode == 0) {
                if (strlen($billingPhone) == 0) {
                    $errCode= 139;
                    $errMessage = 'Billing phone required';
                }
            }


            if ($errCode == 0) {
                $param = array();
                $param['member_id'] = $user->id;
                $param['type'] = 'billing';
                $param['name'] = $billingName;
                $param['phone'] = $billingPhone;
                $param['address'] = $billingAddress;
                $param['email'] = $billingEmail;
                $param['postal'] = $billingZipcode;
                $param['province_id'] = $billingProvinceId;
                $param['city_id'] = $billingCityId;
                $param['districts_id'] = $billingDistrictsId;
                if (strlen($billingAddressId) > 0) {
                    $param['member_address_id'] = $billingAddressId;
                }
                $result = null;
                try {
                    $result = CMember::setMemberAddressType($param);
                } catch(ApiException $e) {
                    $errCode = 2525;
                    $errMessage = $e->getMessage();
                } catch(\Exception $e) {
                    $errCode = 4245;
                    $errMessage = $e->getMessage();
                }
            }

            if ($errCode == 0) {
                $param = array();
                $param['member_id'] = $user->id;
                $param['type'] = 'shipping';
                $param['name'] = $shippingName;
                $param['phone'] = $shippingPhone;
                $param['address'] = $shippingAddress;
                $param['email'] = $shippingEmail;
                $param['postal'] = $shippingZipcode;
                $param['province_id'] = $shippingProvinceId;
                $param['city_id'] = $shippingCityId;
                $param['districts_id'] = $shippingDistrictsId;
                if (strlen($shippingAddressId) > 0) {
                    $param['member_address_id'] = $shippingAddressId;
                }
                $result = null;
                try {
                    $result = CMember::setMemberAddressType($param);
                } catch(ApiException $e) {
                    $errCode = 4141;
                    $errMessage = $e->getMessage();
                } catch(\Exception $e) {
                    $errCode = 42455;
                    $errMessage = $e->getMessage();
                }
            }

            
            if($errCode > 0) {
                cmsg::add('error', $errMessage);
            } else {
                cmsg::add('success', 'Success to modified.');
            }

        }

        //billing
        $data['billing_province'] = CData::getProvince(array());
        $data['billing_city'] = CData::getCity(array('province_id' => $billingProvinceId));
        $data['billing_districts'] = CData::getDistricts(array('city_id' => $billingCityId));
        $data['billing_province_id'] = $billingProvinceId;
        $data['billing_city_id'] = $billingCityId;
        $data['billing_districts_id'] = $billingDistrictsId;
        $data['billing_name'] = $billingName;
        $data['billing_email'] = $billingEmail;
        $data['billing_phone'] = $billingPhone;
        $data['billing_address'] = $billingAddress;
        $data['billing_zipcode'] = $billingZipcode;
        
        //shipping
        $data['shipping_province'] = CData::getProvince(array());
        $data['shipping_city'] = CData::getCity(array('province_id' => $shippingProvinceId));
        $data['shipping_districts'] = CData::getDistricts(array('city_id' => $shippingCityId));;
        $data['shipping_province_id'] = $shippingProvinceId;
        $data['shipping_city_id'] = $shippingCityId;
        $data['shipping_districts_id'] = $shippingDistrictsId;
        $data['shipping_name'] = $shippingName;
        $data['shipping_email'] = $shippingEmail;
        $data['shipping_phone'] = $shippingPhone;
        $data['shipping_address'] = $shippingAddress;
        $data['shipping_zipcode'] = $shippingZipcode;
        $data['from_checkout'] = $fromCheckout;
        $title = 'Tambah Alamat';
        if (strlen($billingAddressId) > 0) {
            $title = 'Update Alamat';
        }
        $data['title'] = $title;
        return view('front.user.address.detail', $data);
    }

    public function delete($billingAddressId = '', $shippingAddressId = '') {
        $errCode = 0;
        $errMessage = '';
        $user = Auth::check() ? Auth::user() : array();
        $param = array();
        $param['member_id'] = $user->id;
        $param['member_address_id'] = $billingAddressId;
        $param['type'] = 'billing';
        try {
            $result = CMember::deleteMemberAddress($param);
        } catch (ApiException $ex) {
            $errCode++;
            $errMessage = $ex->getMessage();
        } catch (\Exception $ex) {
            $errCode++;
            $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
        }

        $param = array();
        $param['member_id'] = $user->id;
        $param['member_address_id'] = $shippingAddressId;
        $param['type'] = 'shipping';
        try {
            $result = CMember::deleteMemberAddress($param);
        } catch (ApiException $ex) {
            $errCode++;
            $errMessage = $ex->getMessage();
        } catch (\Exception $ex) {
            $errCode++;
            $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
        }

        if ($errCode == 0) {
            $success_message = 'Alamat Success dihapus';
            cmsg::add('success', $success_message);
        } else {
            cmsg::add('error', $errMessage);
        }
        return redirect()->to(route('user.address'));
    }

    public function setmain($billingAddressId = '', $shippingAddressId = '') {
        $errCode = 0;
        $errMessage = '';
        $user = Auth::check() ? Auth::user() : array();
        $param = array();
        $param['member_id'] = $user->id;
        $param['member_address_id'] = $billingAddressId;
        $param['type'] = 'billing';
        try {
            $result = CMember::setMemberMainAddress($param);
        } catch (ApiException $ex) {
            $errCode++;
            $errMessage = $ex->getMessage();
        } catch (\Exception $ex) {
            $errCode++;
            $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
        }

        $param = array();
        $param['member_id'] = $user->id;
        $param['member_address_id'] = $shippingAddressId;
        $param['type'] = 'shipping';
        try {
            $result = CMember::setMemberMainAddress($param);
        } catch (ApiException $ex) {
            $errCode++;
            $errMessage = $ex->getMessage();
        } catch (\Exception $ex) {
            $errCode++;
            $errMessage = '[FATAL ERROR] ' . $ex->getMessage();
        }

        if ($errCode == 0) {
            $success_message = 'Success set main address';
            cmsg::add('success', $success_message);
        } else {
            cmsg::add('error', $errMessage);
        }
        return redirect()->to(route('user.address'));
    }

    
}
