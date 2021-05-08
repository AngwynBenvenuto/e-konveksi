<?php

namespace App\Http\Controllers\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cnotif;
use Lintas\helpers\cmsg;
use Lintas\libraries\CUserLogin;
use App\Models\Review;
use App\Models\Kerjasama;
use App\Models\Penawaran;
use App\Models\ProjectData;

use DB, Auth;

class IkmActionController extends Controller {
    public function penjahit_detail($id) {
        $data = array();
        $errCode = '';
        $errMsg = 0;
        $vendor_id = '';
        $name = '';
        $name_display = '';
        $alamat = '';
        $tanggal = '';
        $telepon = '';
        $gender = '';
        $image_url = '';
        $rating = '';
        $penawaranList = array();
        $penawaranArrList = array();

        if(strlen($id) > 0) {
            try{
                $user = \App\Models\Penjahit::whereId($id)->first();
                if($user != null) {
                    $u = $user->toArray();
                    $vendor_id = Arr::get($u, 'id');
                    $name = Arr::get($u, 'name');
                    $name_display = Arr::get($u, 'name_display');
                    $alamat = Arr::get($u, 'address');
                    $telepon = Arr::get($u, 'phone');
                    $tanggal = Arr::get($u, 'birthdate');
                    $tanggal = utils::formatDate($tanggal);
                    $gender = Arr::get($u, 'gender');
                    $image_url = Arr::get($u, 'image_url');
                    $review = \App\Models\Review::where('penjahit_id', '=', $vendor_id)->get();
                    $review_count = $review->count();
                    if($review != null) {
                        $total = 0;
                        foreach($review as $row) {
                            $total += $row->rating;
                            $rating = $total / $review_count;
                        }
                    }
                    $penawaran = \App\Models\Penawaran::where('penjahit_id', '=', $vendor_id)->get();
                    if($penawaran != null) {
                        $penawaranCount = $penawaran->count();
                        $penawaranArr = $penawaran->toArray();
                        foreach($penawaranArr as $r) {
                            $project = \App\Models\Project::find($r['project_id'])->toArray();
                            $penawaranArrList[] = array(
                                'name' => $project['name'],
                                'price' => $r['offer_price'],
                                'image_url' => null,

                            );
                        }
                        $r = array_map("unserialize", array_unique(array_map("serialize", $penawaranArrList)));
                        foreach($r as $row_penawaran) {
                            $penawaranList[] = $row_penawaran;
                        }
                    }
                    // $review = Arr::get($u, 'review');
                    // foreach($review as $row_review) {
                    //     $rating = $row_review['rating'];
                    // }
                }
            } catch(\Exception $e) {
                $errCode = 1414;
                $errMsg = $e->getMessage();
            }

            if($errCode > 0) {
                cmsg::add('error', $errMsg);
            }
        }

        $data['vendor_id'] = $vendor_id;
        $data['name'] = $name;
        $data['name_display'] = $name_display;
        $data['alamat'] = $alamat;
        $data['phone'] = $telepon;
        $data['birthdate'] = $tanggal;
        $data['gender'] = $gender == 1 ? "Laki-laki" : "Perempuan";
        $data['image_url'] = $image_url;
        $data['penawaranList'] = $penawaranList;
        $data['rating'] = $rating;
        $data['review'] = $review;
        return view('admin.ikm.penjahit', $data);
    }

    public function hire($id) {
        $data = array();
        $errCode = '';
        $errMsg = 0;
        $request = array_merge($_GET, $_POST);

        $penjahit = \App\Models\Penjahit::find($id)->name;
        $ukuran = \App\Models\Ukuran::where('status', '>', 0)->get()->toArray();
        $nama = '';
        $url = '';
        $kode = '';
        $harga = '';
        $rentang = '';
        $video = '';
        $deskripsi = '';
        $spesifikasi = '';
        $ikm_id = '';
        $project_ukuran = '';
        $tanggal = '';
        $image = array();
        $ukuranArr = array();

        if($request != null) {
            $nama = Arr::get($request, 'project_name');
            $url = Arr::get($request, 'url');
            $tanggal = Arr::get($request, 'project_published_date');
            $harga = Arr::get($request, 'project_price');
            $rentang = Arr::get($request, 'project_deadline');
            $size_guide_anak = $_FILES;
            $size_guide_dewasa = $_FILES;
            $video = Arr::get($request, 'project_video');
            $deskripsi = Arr::get($request, 'project_description');
            $spesifikasi = Arr::get($request, 'project_spesification');
            $image = Arr::get($request, 'image');
            $project_ukuran = Arr::get($request, 'projectUkuran');
            $project_ukuran_qty = Arr::get($request, 'projectUkuranValue');

            if($errCode == 0) {
                $param = array();
                $param['ikm_id'] = CUserLogin::get('id');
                if(strlen($penjahit) > 0) {
                    $param['tailor_id'] = $id;
                    $param['tailor'] = $penjahit;
                }
                $param['code'] = $kode;
                $param['name'] = $nama;
                $param['url'] = $url;
                $param['published_date'] = $tanggal;
                $param['deadline'] = $rentang;
                $param['price'] = utils::unformatCurrency($harga);
                $param['size_guide_anak'] = $size_guide_anak;
                $param['size_guide_dewasa'] = $size_guide_dewasa;
                $param['video'] = $video;
                $param['is_project_private'] = 1;
                $param['description'] = $deskripsi;
                $param['spesification'] = $spesifikasi;
                if($project_ukuran != null) {
                    if(count($project_ukuran) > 0) {
                        for($i = 0; $i < count($project_ukuran); $i++) {
                            $ukuran_temp[] = array(
                                'ukuran_id' => $project_ukuran[$i],
                                'qty' => $project_ukuran_qty[$i]
                            );
                        }
                        $param['project_ukuran'] = $ukuran_temp;
                    }
                }
                if($image != null) {
                    if(count($image) > 0) {
                        $param['image'] = $image;
                    }
                }
                // if(strlen($id) > 0) {
                //     $param['id'] = $id;
                //

                $result = false;
                try{
                    $result = \Lintas\libraries\CProject::projectUpdate($param);
                } catch(ApiException $ex) {
                    $errCode = 552;
                    $errMsg = $ex->getMessage();
                } catch(\Exception $ex) {
                    $errCode++;
                    $errMsg = $ex->getMessage();
                }

                if($errCode == 0) {
                    $msg = " Success insert";
                    if(strlen($id) > 0) {
                        $msg = " Success modified";
                    }
                    cmsg::add('success', $nama.$msg);
                    return redirect(route('admin.dashboard'));
                } else {
                    cmsg::add('error', $errMsg);
                }
            }
        }

        $data['penjahit'] = $penjahit;
        $data['ukuran'] = $ukuran;
        $data['kode'] = $kode;
        $data['url'] = $url;
        $data['nama'] = $nama;
        $data['tanggal'] = $tanggal;
        $data['harga'] = $harga;
        $data['rentang'] = $rentang;
        $data['video'] = $video;
        $data['deskripsi'] = $deskripsi;
        $data['spesifikasi'] = $spesifikasi;
        $data['image'] = $image;
        $data['project_ukuran'] = $ukuranArr;
        $data['id'] = $id;
        $data['title'] = 'Hire Me';
        return view('admin.ikm.hire', $data);
    }


    public function project_detail($id, $url = null)
    {
        $data = array();
        $errCode = 0;
        $errMsg = '';

        $project_id = '';
        $name = '';
        $kode = '';
        $harga = 0;
        $waktu='';
        $ukuran='';
        $deskripsi = '';
        $spesifikasi = '';
        $kode = '';
        $views = '';
        $tanggal_mulai = '';
        $waktu = '';
        $image = '';
        $image_url = '';
        $image_name = '';
        $video = '';
        $size_guide_anak = $size_guide_dewasa = '';
        $file = $file_url = '';
        $tailor = $tailor_id = $tailor_name = '';
        $ukurans = array();

        if(strlen($id) > 0)
        {
            try {
                $project = \App\Models\Project::with(['ukuran', 'images'])->whereId($id)->first();
                if($project != null) {
                    $project_items = $project->toArray();
                    $project_id = Arr::get($project_items, 'id');
                    $name = Arr::get($project_items, 'name');
                    $kode = Arr::get($project_items, 'code');
                    $harga = Arr::get($project_items, 'price');
                    $url = Arr::get($project_items, 'url');
                    $deskripsi = Arr::get($project_items, 'description');
                    $spesifikasi = Arr::get($project_items, 'spesification');
                    $views = Arr::get($project_items, 'views');
                    $tanggal_mulai = Arr::get($project_items, 'published_date');
                    $waktu = Arr::get($project_items, 'deadline');
                    $image = Arr::get($project_items, 'images');
                    $video = Arr::get($project_items, 'video_url');
                    $tailor = Arr::get($project_items, 'tailor');
                    $is_tailor = Arr::get($project_items, 'is_signed_tailor');
                    $size_guide_anak = Arr::get($project_items, 'size_guide_anak');
                    $size_guide_dewasa = Arr::get($project_items, 'size_guide_dewasa');
                    if($image != null) {
                        foreach($image as $row) {
                            $file = $row['image_name'];
                            $file_url = $row['image_url'];
                        }
                        $image_name = $file;
                        $image_url = $file_url;
                    }
                    $ukuran = Arr::get($project_items, 'ukuran');
                    if($ukuran != null) {
                        foreach($ukuran as $r) {
                            $ukurans[] = array(
                                'ukuran_id' => $r['pivot']['ukuran_id'],
                                'ukuran_nama' => $r['name'],
                                'qty' => $r['pivot']['qty']
                            );
                        }
                    }
                    // $penawaran = array_get($p, 'penawaran');
                    // if($penawaran != null)
                    // {
                    //     $penawaranCount = count($penawaran);
                    //     $r = array_map("unserialize", array_unique(array_map("serialize", $penawaranArr)));
                    //     foreach($r as $row_penawaran) {
                    //         $penawaranList[] = $row_penawaran;
                    //     }
                    // }
                }
            } catch(\Exception $e) {
                $errCode = 1414;
                $errMsg = $e->getMessage();
            }
        }

        $data['project_id'] = $project_id;
        $data['name'] = $name;
        $data['kode'] = $kode;
        $data['ukuran'] = $ukurans;
        $data['deskripsi'] = $deskripsi;
        $data['spesifikasi'] = $spesifikasi;
        $data['views'] = $views.'x';
        $data['tanggal_mulai'] = utils::formatDate($tanggal_mulai);
        $data['images'] = $image;
        $data['image_name'] = $image_name;
        $data['image_url'] = $image_url;
        $data['size_guide_anak'] = $size_guide_anak;
        $data['size_guide_dewasa'] = $size_guide_dewasa;
        $data['video'] = $video;
        if(strlen($tailor) > 0 && $tailor != null) {
            $data['tailor_id'] = $tailor;
            $data['tailor_name'] = \App\Models\Penjahit::find($tailor)->name;
            $data['is_tailor'] = $is_tailor;
        } else {
            $data['tailor_id'] = $tailor_id;
            $data['tailor_name'] = $tailor_name;
            $data['is_tailor'] = $is_tailor;
        }
        $data['title'] = $name;
        return view('admin.ikm.project_detail', $data);
    }

    //transaksi
    public function transaksi_ikm() {
        $data = array();
        $data['title'] = "Transaksi IKM List";
        return view('admin.ikm.list', $data);
    }



    //penawaran
    public function penawaran_ikm() {
        $data = array();
        $data['title'] = "Penawaran IKM List";
        return view('admin.ikm.offer', $data);
    }
    // public function penawaran_ikm_getdata() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $penawaran_id = Arr::get($request, 'penawaran_id');
    //     }

    //     if($errCode == 0) {
    //         if(strlen($penawaran_id) == 0) {
    //             $errCode++;
    //             $errMsg = "Penawaran ID required";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $result = \App\Models\Penawaran::where('id', '=', $penawaran_id)->first();
    //         if($result != null) {
    //             $data['ikm_id'] = $result->ikm_id;
    //             if($result->ikm_id != null) {
    //                 $data['ikm_name'] = \App\Models\Ikm::find($result->ikm_id)->name;
    //                 $data['ikm_code'] = \App\Models\Ikm::find($result->ikm_id)->code;
    //             }
    //             $data['penjahit_id'] = $result->penjahit_id;
    //             if($result->penjahit_id != null) {
    //                 $data['penjahit_name'] = \App\Models\Penjahit::find($result->penjahit_id)->name;
    //                 $data['penjahit_code'] = \App\Models\Penjahit::find($result->penjahit_id)->code;
    //             }
    //             $data['project_id'] = $result->project_id;
    //         } else {
    //             $errCode = 14667;
    //             $errMsg = "Data not found";
    //         }
    //     }

    //     $array = array();
    //     if($errCode == 0) {
    //         $array['errCode'] = $errCode;
    //         $array['errMsg'] = $errMsg;
    //         $array['data'] = $data;
    //     } else {
    //         $array['errCode'] = $errCode;
    //         $array['errMsg'] = $errMsg;
    //     }
    //     return response()->json($array, 200);
    // }



    // public function kerjasama_session() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $id = Arr::get($request, 'id');
    //         if($errCode == 0) {
    //             if(strlen($id) == 0) {
    //                 $errCode = 13;
    //                 $errMsg = "ID required";
    //             }
    //         }
    //         if($errCode == 0) {
    //             \Session::put('transaksi_id', $id);
    //         }
    //     }
    //     return response()->json(array('message' => 'success save session'), 200);
    // }
    public function kerjasama() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        // if($request != null) {
        //     $transaksi_id = Arr::get($request, 'transaksi_id');
        // }
        $transaksi_id = \Session::get('transaksi_id');
        $ikm_id = '';
        $penjahit_name = '';
        $penjahit_name_display = '';
        $penjahit_id = '';
        $transaction_price = '';
        $project_id = '';
        $project_code = '';
        $project_image = '';
        $project_nama = '';
        $project_url = '';
        $project_harga = '';
        $project_date = '';
        $file = '';
        $file_name = '';
        $penjahit_address = '';
        $image_url = $image_name = '';
        $project_deskripsi = '';
        $ukurans = array();

        if($transaksi_id != null) {
            $transaksi = \App\Models\Transaksi::find($transaksi_id);
            if($transaksi != null) {
                $project_id = $transaksi->project_id;
                $ikm_id = $transaksi->ikm_id;
                $penjahit_id = $transaksi->penjahit_id;
                $transaction_price = $transaksi->transaction_price;
                $penjahit = \App\Models\Penjahit::find($penjahit_id);
                if($penjahit != null) {
                    $penjahit_name = $penjahit->name;
                    $penjahit_name_display = $penjahit->name_display;
                    $penjahit_address = $penjahit->address;
                }

                $project = \App\Models\Project::with(['ukuran', 'images'])->whereId($project_id)->first();
                if($project != null) {
                    $models = $project->toArray();
                    $project_id = Arr::get($models, 'id');
                    $project_nama = Arr::get($models, 'name');
                    $project_url = Arr::get($models, 'url');
                    $project_code = Arr::get($models, 'code');
                    $project_harga = Arr::get($models, 'price');
                    $project_date = Arr::get($models, 'published_date');
                    $project_deskripsi = Arr::get($models, 'spesification');
                    $ukuran = Arr::get($models, 'ukuran');
                    if($ukuran != null) {
                        foreach($ukuran as $r) {
                            $ukurans[] = array(
                                'ukuran_id' => $r['pivot']['ukuran_id'],
                                'ukuran_nama' => $r['name'],
                                'qty' => $r['pivot']['qty']
                            );
                        }
                    }
                    $image = Arr::get($models, 'images');
                    if($image != null) {
                        foreach($image as $row) {
                            $file = $row['image_name'];
                            $file_url = $row['image_url'];
                        }
                        $image_name = $file;
                        $image_url = $file_url;
                    }
                }
            }
        }

        if($request != null) {
            $nomor_perusahaan = Arr::get($request, 'nomor_perusahaan');
            $nama_perusahaan = Arr::get($request, 'nama_perusahaan');
            $jangka_waktu = Arr::get($request, 'jangka_waktu');
            if($errCode == 0) {
                if(strlen($nomor_perusahaan) == 0) {
                    $errCode++;
                    $errMsg = "nomor required";
                }
            }

            if($errCode == 0) {
                $dataKerjasama = array(
                    'transaksi_id' => $transaksi_id,
                    'nama_perusahaan' => $nama_perusahaan,
                    'nomor_perusahaan' => $nomor_perusahaan,
                    'jangka_pengerjaan' => $jangka_waktu,
                );
                $modelKerjasama = new Kerjasama;
                $modelKerjasama->fill($dataKerjasama);
                $save = $modelKerjasama->save();
                if($save) {
                    try{
                        $newDate = date('Y-m-d', strtotime("+".$jangka_waktu." MONTH", strtotime($project_date)));
                        $city_id = CUserLogin::get('city_id');
                        $city = \App\Models\City::find($city_id)->name;
                        $file = public_path('data/rtf/suratperjanjian.rtf');
                        $options = array(
                            '[TANGGAL]' => date('Y-m-d'),
                            '[NAMA_PERUSAHAAN]' => $nama_perusahaan,
                            '[NOMOR_PERUSAHAAN]' => $nomor_perusahaan,
                            '[PIHAK_1]' => CUserLogin::get('name'),
                            '[ALAMAT_1]' => CUserLogin::get('address'),
                            '[PIHAK_2]' => $penjahit_name,
                            '[ALAMAT_2]' => $penjahit_address,
                            '[PROJECT]' => $project_nama,
                            '[PRICE]' => config('cart.currency').number_format($transaction_price,2),
                            '[METODE]' => 'Transfer',
                            '[TERBIT]' => $city.", ".date('Y-m-d'),
                            '[START]' => utils::formatDate($project_date),
                            '[END]' => $newDate,
                        );
                        $nama_file = 'surat-perjanjian-kerjasama.doc';
                        return \WordTemplate::export($file, $options, $nama_file);
                    } catch(\Exception $e) {
                        $errCode++;
                        $errMsg = $e->getMessage();
                    }
                }
            }

            if($errCode > 0) {
                cmsg::add('error', $errMsg);
            }
        }

        $data['title'] = "Form kerjasama";
        $data['penjahit'] = $penjahit_name;
        $data['project_nama'] = $project_nama;
        $data['image'] = $image_url;
        $data['code'] = $project_code;
        $data['bahan'] = $project_deskripsi;
        $data['ukuran'] = $ukurans;
        return view('admin.ikm.kerjasama', $data);
    }

    public function review() {
        $errCode = 0;
        $errMsg = '';
        $note = '';
        $invoice_id = '';
        $invoice = '';
        $penjahit_id = '';
        $penjahit_name = '';
        $ikm_id = '';
        $ikm_name = '';
        $transaction_id = '';
        $transaction_code = '';
        $project_id = '';
        $project_name = '';

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            $transaksi = \App\Models\Transaksi::find($transaksi_id);
            if($transaksi != null) {
                $transaction_id = $transaksi->id;
                $transaction_code = $transaksi->code;
                $penjahit_id = $transaksi->penjahit_id;
                $penjahit = \App\Models\Penjahit::find($penjahit_id);
                if($penjahit != null) {
                    $penjahit_name = $penjahit->name_display;
                }

                $ikm_id = $transaksi->ikm_id;
                $ikm = \App\Models\Ikm::find($ikm_id);
                if($ikm != null) {
                    $ikm_name = $ikm->name_display;
                }

                $project_id = $transaksi->project_id;
                $project = \App\Models\Project::find($project_id);
                if($project != null) {
                    $project_name = $project->name;
                }
            }
        }

        $data = array();
        $data['title'] = "Review";
        $data['invoice_id'] = $invoice_id;
        $data['invoice'] = $invoice;
        $data['transaction_id'] = $transaction_id;
        $data['transaction_code'] = $transaction_code;
        $data['ikm_id'] = $ikm_id;
        $data['ikm_name'] = $ikm_name;
        $data['project_id'] = $project_id;
        $data['project_name'] = $project_name;
        $data['penjahit_id'] = $penjahit_id;
        $data['penjahit_name'] = $penjahit_name;
        return view('admin.ikm.review', $data);
    }

    public function project_data($id = null) {
        $errCode = 0;
        $errMsg = '';
        $request = array_merge($_GET, $_POST);
        $penjahit_id = '';
        $penjahit_name = '';
        $transaction_id = '';
        $transaction_code = '';
        $project_id = '';
        $project_name = '';
        $brand='';
        $jenis_kain='';
        $cara_perawatan='';

        if($errCode == 0) {
            $transaksi = \App\Models\Transaksi::find($id);
            if($transaksi != null) {
                $transaction_id = $transaksi->id;
                $transaction_code = $transaksi->code;
                $penjahit_id = $transaksi->penjahit_id;
                $penjahit = \App\Models\Penjahit::find($penjahit_id);
                if($penjahit != null) {
                    $penjahit_name = $penjahit->name_display;
                }
                $project_id = $transaksi->project_id;
                $project = \App\Models\Project::find($project_id);
                if($project != null) {
                    $project_name = $project->name;
                }
            }
        }

        if($request != null) {
            $brand = Arr::get($request, 'brand');
            $jenis_kain = Arr::get($request, 'jenis_kain');
            $cara_perawatan = Arr::get($request, 'perawatan');

            if(strlen($brand)==0)
            {
                $errCode=111;
                $errMsg='Brand harus diisi';
            }
            else if(strlen($jenis_kain)==0)
            {
                $errCode=112;
                $errMsg='Jenis kain harus diisi';
            }
            else if(strlen($cara_perawatan)==0)
            {
                $errCode=007;
                $errMsg='Cara perawatan harus diisi';
            }


            if($errCode == 0) {
                try{
                    $dataProject = array(
                        'transaksi_id' => $transaction_id,
                        'jenis_kain' => $jenis_kain,
                        'brand' => $brand,
                        'cara_perawatan' => $cara_perawatan
                    );

                    $modelProjectData= new ProjectData;
                    $modelProjectData->fill($dataProject);
                    $save = $modelProjectData->save();
                    if($save) {
                        $id = $modelProjectData->id;
                    }
                }catch(\Exception $e){
                    $errCode = 123;
                    $errMsg = $e->getMessage();
                }
            }

            if($errCode > 0){
                cmsg::add('error',$errMsg);
            } else {
                $url = route("admin.project_data_detail", $id);
                return redirect($url);
            }
        }

        $data = array();
        $data['title'] = "Insert Detail Produk Jadi";
        $data['transaction_id'] = $transaction_id;
        $data['transaction_code'] = $transaction_code;
        $data['project_id'] = $project_id;
        $data['project_name'] = $project_name;
        $data['penjahit_id'] = $penjahit_id;
        $data['penjahit_name'] = $penjahit_name;
        return view('admin.ikm.project_data', $data);
    }

    public function project_data_detail($id = null) {
        $transaksi_id = '';
        $penjahit_id = '';
        $penjahit_name = '';
        $transaction_id = '';
        $transaction_code = '';
        $project_id = '';
        $project_name = '';
        $project_qr = '';
        $brand='';
        $jenis_kain='';
        $cara_perawatan='';

        if(strlen($id) > 0) {
            $project_data = ProjectData::find($id);
            if($project_data != null) {
                $transaksi_id = $project_data->transaksi_id;
                $transaksi = \App\Models\Transaksi::find($transaksi_id);
                if($transaksi != null) {
                    $transaction_id = $transaksi->id;
                    $transaction_code = $transaksi->code;
                    $penjahit_id = $transaksi->penjahit_id;
                    $penjahit = \App\Models\Penjahit::find($penjahit_id);
                    if($penjahit != null) {
                        $penjahit_name = $penjahit->name_display;
                    }
                    $project_id = $transaksi->project_id;
                    $project = \App\Models\Project::find($project_id);
                    if($project != null) {
                        $project_name = $project->name;
                        $project_qr = $project->qr_code;
                    }
                }
                $brand = $project_data->brand;
                $jenis_kain = $project_data->jenis_kain;
                $cara_perawatan = $project_data->cara_perawatan;
            }


        }

        $data = array();
        $data['title'] = "Detail Produk Jadi";
        $data['transaction_id'] = $transaction_id;
        $data['transaction_code'] = $transaction_code;
        $data['project_id'] = $project_id;
        $data['project_name'] = $project_name;
        $data['project_qr'] = $project_qr;
        $data['penjahit_id'] = $penjahit_id;
        $data['penjahit_name'] = $penjahit_name;
        $data['jenis_kain'] = $jenis_kain;
        $data['brand'] = $brand;
        $data['cara_perawatan'] = $cara_perawatan;
        return view('admin.ikm.project_data_detail', $data);
    }
    // public function review_session() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $id = Arr::get($request, 'id');
    //         if($errCode == 0) {
    //             if(strlen($id) == 0) {
    //                 $errCode = 13;
    //                 $errMsg = "ID required";
    //             }
    //         }
    //         if($errCode == 0) {
    //             $review = Review::find($id);
    //             if($review == null) {
    //                 \Session::put('transaksi_id', $id);
    //             } else {
    //                 $errCode = 1444;
    //                 $errMsg = "Data review sudah ada";
    //             }
    //         }
    //     }
    //     $r = array();
    //     if($errCode == 0) {
    //         $r['errCode'] = $errCode;
    //         $r['errMsg'] = $errMsg;
    //         $r['data'] = $data;
    //     } else {
    //         $r['errCode'] = $errCode;
    //         $r['errMsg'] = $errMsg;
    //     }
    //     return response()->json($r, 200);
    // }
    //
    // public function insert_review() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $data = array();
    //     $note = '';
    //     $penjahit_name = '';
    //     $transaction_code = '';
    //     $project_name = '';
    //     $request = array_merge($_GET, $_POST);
    //     $ikm_id = CUserLogin::get('id');
    //     $ikm_name = CUserLogin::get('name_display');
    //     $transaksi_id = \Session::get('transaksi_id');
    //     if($errCode == 0) {
    //         if(strlen($transaksi_id) == 0){
    //             $errCode = 135;
    //             $errMsg = "Transaksi ID required";
    //         }
    //         $transaksi = \App\Models\Transaksi::find($transaksi_id);
    //         if($transaksi != null) {
    //             $transaction_code = $transaksi->code;
    //             $penjahit_id = $transaksi->penjahit_id;
    //             $penjahit = \App\Models\Penjahit::find($penjahit_id);
    //             if($penjahit != null) {
    //                 $penjahit_name = $penjahit->name_display;
    //             }

    //             $project_id = $transaksi->project_id;
    //             $project = \App\Models\Project::find($project_id);
    //             if($project != null) {
    //                 $project_name = $project->name;
    //             }
    //         } else {
    //             $errCode = 1111;
    //             $errMsg = "Data not found";
    //         }
    //     }
    //     if($request != null) {
    //         $rating = Arr::get($request, 'rating_value');
    //         $note = Arr::get($request, 'note');
    //         if($errCode == 0) {
    //             if(strlen($ikm_id) == 0){
    //                 $errCode = 134;
    //                 $errMsg = "Ikm required";
    //             }
    //         }
    //         if($errCode == 0) {
    //             try{
    //                 //insert to table review
    //                 $dataReview = array(
    //                     'ikm_id' => $ikm_id,
    //                     'transaksi_id' => $transaksi_id,
    //                     'project_id' => $project_id,
    //                     'penjahit_id' => $penjahit_id,
    //                     'rating' => $rating,
    //                     'rating_request' => date('Y-m-d H:i:s'),
    //                     'note' => $note
    //                 );
    //                 //dd($dataReview);
    //                 $review = new Review;
    //                 $review->fill($dataReview);
    //                 $review->save();
    //             }catch(\Exception $e) {
    //                 $errCode = 1455;
    //                 $errMsg = $e->getMessage();
    //             }
    //         }
    //         if($errCode > 0) {
    //             cmsg::add('error', $errMsg);
    //         }
    //     }
    //     $data['title'] = "Review";
    //     $data['ikm_name'] = $ikm_name;
    //     $data['project_name'] = $project_name;
    //     $data['penjahit_name'] = $penjahit_name;
    //     $data['transaction_code'] = $transaction_code;
    //     $data['note'] = $note;
    //     return view('admin.ikm.review', $data);
    // }


}
