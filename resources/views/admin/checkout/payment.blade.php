<?php
 use Lintas\libraries\CUserLogin;
?>
@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="container">
            @include('admin/checkout/nav/wizard')
        </div>
        <div class="container">
            <div class="payment-back mb-4">
                <a class="btn btn-primary" href="{{ route('admin.checkout.shipping') }}">
                    <i class="fas fa-chevron-left"></i>
                    <?php echo __('Kembali ke pembayaran'); ?>
                </a>

            </div>
            <form id="form_payment" method="post" action="">
                @csrf
                <div class="card mb-3">
                    <div class="card-body">
                        <?php
                            $province_name_sender = $city_name_sender = '';
                            echo "<b>Dikirim Oleh</b>: <br>";
                            echo "Nama: ".CUserLogin::get('name')."<br>";
                            echo "Alamat: ".CUserLogin::get('address')."<br>";
                            echo "Email: ".CUserLogin::get('email')."<br>";
                            echo "Telepon: ".CUserLogin::get('phone')."<br>";
                            $province_sender = \App\Models\Province::find(CUserLogin::get('province_id'));
                            if($province_sender != null) {
                                $province_name_sender = $province_sender->name;
                            }
                            $city_sender = \App\Models\City::find(CUserLogin::get('city_id'));
                            if($city_sender != null) {
                                $city_name_sender = $city_sender->name;
                            }
                            //$city_name_sender = \App\Models\City::find(CUserLogin::get('city_id'))->name;
                            echo "Provinsi: ".$province_name_sender."<br>";
                            echo "Kota: ".$city_name_sender."<br>";

                        ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Province</th>
                                    <th>City</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>{{ $email }}</td>
                                    <td>{{ $province_name }}</td>
                                    <td>{{ $city_name }}</td>
                                    <td>{{ $address }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="">
                            <span><b>Barang yang dikirim: </b></span> {{ $barang }}
                        </div>
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Kode Transaksi</th>
                                    <th>Harga Project</th>
                                    <th>Harga Penawaran Yang Diterima</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $project_name }}</td>
                                    <td>{{ $transaction_code }}</td>
                                    <td>{{ $project_price }}</td>
                                    <td>{{ $price }}</td>
                                    <td>{{ $transaction_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- transaction overview -->
                        <table class="table table-bordered" id="table-shipping" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kurir</th>
                                    <th>Bank</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $kurir }}</td>
                                    <td>{{ $bank }}</td>
                                    <td>{{ $payment_method }}</td>
                                    <td>{{ $payment_total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <input type="submit" class="shipping-continue border-0 w-100 text-white py-3 btn btn-primary mb-3" value="<?php echo __('Lakukan Pembayaran'); ?>" />
            </form>
        </div>
    </div>
@endsection