<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Penawaran;
use App\Models\Ikm;
use Auth, DB;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use Lintas\helpers\cdbutils;
use Lintas\helpers\cnotif;
use Lintas\libraries\CMemberLogin;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    public function index()
    {
        //$checkLogin = CMemberLogin::get('id');
        $data = array();
        $view_page = 8;
        $keyword = '';
        $model = Project::where('status', '>', 0);
        
        //
        // if(CMemberLogin::get('id') != null) {
        //     $checkmodel = Project::where('tailor', '=', CMemberLogin::get('id'))->get();
        //     if($checkmodel->count() == 0) {
        //         $model = $model->whereNull('tailor')
        //                         >where('is_project_private','<>', 1);
        //     } else {
        //         $model = $model->where('tailor', '=', CMemberLogin::get('id'))
        //                         ->where('is_project_private','=',1);
        //     }
        // } 
        // else {
        //     $model = $model->where('is_project_private','=',0);
        // }

        //
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $priceStart = Arr::get($request, 'price_start');
            $priceEnd = Arr::get($request, 'price_end');
            $viewPage = Arr::get($request, 'view_page', 10);
            $keyword = Arr::get($request, 'keyword');
            $param = array(
                'keyword' => $keyword,
                'price_start' => $priceStart,
                'price_end' => $priceEnd,
            );
            $model->filter($param);
            $count = $model->count();
        }

        //dd($model);

        $project = $model->paginate($view_page);

        $data['project'] = $project;
        $data['keyword'] = $keyword;
        return view('front.project.index', $data);
    }

    public function detail(Request $request, $url = null) {
        $data = array();
        $errCode = 0;
        $errMsg = '';
        $id = '';
        $name = '';
        $kode = '';
        $harga = 0;
        $deskripsi = '';
        $waktu = '';
        $spesifikasi = '';
        $kode = '';
        $nego = '';
        $views = '';
        $tanggal_mulai = '';
        $waktu = '';
        $image = '';
        $image_url = '';
        $image_name = '';
        $video = '';
        $size_guide_anak = $size_guide_dewasa = '';
        $file = '';
        $file_url = '';
        $owner_id = '';
        $owner_user = '';
        $owner_code = '';
        $owner_image = '';
        $owner_alamat = '';
        $ukuran = '';
        $ukurans = array();
        $date = '';
        $tailor = '';
        $tailor_id = '';
        $penjahit_id = '';
        $tailor_name = '';
        $is_tailor = '';
        $penawaranArr = array();//total semua penawaran by project
        $penawaranList = array();
        $penawaranAccept = '';
        $penawaranCount = 0;
        $related = array();
        //$model[]='';

        try {
            //DB::enableQueryLog();
            $model = Project::with(['images', 'ikm', 'ukuran', 'penawaran'])
                        ->where('url', '=', $url);
            // if(CMemberLogin::get('id') != null) {
            //     $checkmodel = Project::where('tailor', '=', CMemberLogin::get('id'))->get();
            //     if($checkmodel->count() == 0) {
            //         $model = $model->whereNull('tailor')
            //                         >where('is_project_private','<>', 1);
            //     } else {
            //         $model = $model->where('tailor', '=', CMemberLogin::get('id'))
            //                        ->where('is_project_private','=',1);
            //     }
            // } 
            
                        // ->where('is_project_private','<>',1)
            $model = $model->first();
            //dd(DB::getQueryLog());
            if($model == null) {
                $errCode = 1456;
                $errMsg = "Error, project not found";
            } else {
                $model->update(['views' => $model->views + 1]);
                $project = $model->toArray();
                if(count($project) > 0) {
                    $id = Arr::get($project, 'id');
                   // \Session::put('project_id', $id);
                    $name = Arr::get($project, 'name');
                    $kode = Arr::get($project, 'code');
                    $harga = Arr::get($project, 'price');
                    $url = Arr::get($project, 'url');
                    $deskripsi = Arr::get($project, 'description');
                    $spesifikasi = Arr::get($project, 'spesification');
                    $views = Arr::get($project, 'views');
                    $tanggal_mulai = Arr::get($project, 'published_date');
                    $waktu = Arr::get($project, 'deadline');
                    $image = Arr::get($project, 'images');
                    $video = Arr::get($project, 'video_url');
                    $tailor = Arr::get($project, 'tailor');
                    $is_tailor = Arr::get($project, 'is_signed_tailor');
                    $size_guide_anak = Arr::get($project, 'size_guide_anak');
                    $size_guide_dewasa = Arr::get($project, 'size_guide_dewasa');
                    if($image != null) {
                        foreach($image as $row) {
                            $file = $row['image_name'];
                            $file_url = $row['image_url'];
                        }
                        $image_name = $file;
                        $image_url = $file_url;
                    }

                    $ikm = Arr::get($project, 'ikm');
                    if($ikm != null) {
                        $owner_id = $ikm['id'];
                        $owner_code = $ikm['code'];
                        $owner_user = $ikm['name'];
                        //$owner_user_display = $ikm['name_display'];
                        $owner_image = $ikm['image_url'];
                        $owner_alamat = $ikm['address'];
                    }

                    $ukuran = Arr::get($project, 'ukuran');
                    if($ukuran != null) {
                        foreach($ukuran as $r) {
                            $ukurans[] = array(
                                'ukuran_id' => $r['pivot']['ukuran_id'],
                                'ukuran_nama' => $r['name'],
                                'qty' => $r['pivot']['qty']
                            );
                        }
                    }

                    $related = $model->where('views', '>', 0)->inRandomOrder()->take(5)->get();

                    $penawaran = Arr::get($project, 'penawaran');
                    if($penawaran != null) {
                        $penawaranCount = count($penawaran);

                        //list
                        foreach($penawaran as $r) {
                            $penjahit = \App\Models\Penjahit::find($r['penjahit_id'])->toArray();
                            $penawaranArr[] = array(
                                'type' => $r['type'],
                                'penjahit_name' => $penjahit['name']." "."(penjahit)",
                                'penjahit_image' => $penjahit['image_url'],
                                'penjahit_address' => $penjahit['address'],
                                'is_approve_ikm' => $r['is_approve_ikm'],
                                'is_approve_penjahit' => $r['is_approve_penjahit'],
                                'date_approve' => $r['last_approve'],
                                'status_confirm' => $r['status_confirm']
                            );
                        }
                        $r = array_map("unserialize", array_unique(array_map("serialize", $penawaranArr)));
                        foreach($r as $row_penawaran) {
                            $penawaranList[] = $row_penawaran;
                        }


                        //accept
                        $accept = array_filter($penawaranArr, function ($value) {
                            return (($value["is_approve_ikm"] > 0 &&
                                     $value["is_approve_penjahit"] > 0) &&
                                    ($value["date_approve"] !== null ||
                                     $value["status_confirm"] == "Confirm"));
                        });
                        if(!empty($accept)) $penawaranAccept = max($accept);
                    }
                }
            }



        } catch (\Exception $e) {
            $errCode = 1444;
            $errMsg = $e->getMessage();
        }

        if($errCode > 0) {
            cmsg::add('error', $errMsg);
        }

        $data['id'] = $id;
        $data['name'] = $name;
        $data['url'] = $url;
        $data['harga'] = $harga;
        $data['tanggal_mulai'] = utils::formatDate($tanggal_mulai);
        //$data['spesifikasi'] = $spesifikasi;
        $data['deskripsi'] = $spesifikasi;
        //dd($deskripsi);
        $data['kode'] = $kode;
        $data['views'] = $views.'x';
        $data['title'] = $name;
        //$data['waktu'] = $waktu.' Bulan';
        $data['images'] = $image;
        $data['image_name'] = $image_name;
        $data['video'] = $video;
        if(strlen($tailor) > 0 && $tailor != null) {
            $data['tailor_id'] = $tailor;
            $data['tailor_name'] = \App\Models\Penjahit::find($tailor)->name;
            $data['is_tailor'] = $is_tailor;
        } else {
            $data['tailor_id'] = $tailor_id;
            $data['penjahit_id'] = $tailor_id;
            $data['tailor_name'] = $tailor_name;
            $data['is_tailor'] = $is_tailor;
        }
        // $data['size_guide'] = $size_guide;
        $data['size_guide_anak'] = $size_guide_anak;
        $data['size_guide_dewasa'] = $size_guide_dewasa;
        $data['image_url'] = $image_url;
        $data['owner_id'] = $owner_id;
        $data['owner_code'] = $owner_code;
        $data['owner_user'] = $owner_user;
        $data['owner_alamat'] = $owner_alamat;
        $data['owner_image'] = $owner_image;
        $penjahit = \Lintas\libraries\CMemberLogin::get();
        if($penjahit != null) {
            $data['penjahit_id'] = \Lintas\libraries\CMemberLogin::get('id');
            $data['penjahit_code'] = \Lintas\libraries\CMemberLogin::get('code');
        }
        $data['ukuran'] = $ukurans;
        $data['penawaranList'] = $penawaranList;
        $data['penawaranAccept'] = $penawaranAccept;
        $data['penawaranCount'] = $penawaranCount.'x';
        $data['related'] = $related;
        return view('front.project.detail', $data);
    }

    public function bid($param) {
        $data = array();
        $errCode = 0;
        $errMsg = '';
        $project_id = '';
        $project_nama = '';
        $type = 'bid';
        $project_url = '';
        $project_harga = '';
        $project_deskripsi = '';
        $owner = '';
        $owner_id = '';
        $owner_nama = '';
        $ukuran = '';
        $penjahit_id = Auth::check() ? Auth::user()->id : '';
        $ukurans = array();
        $request = array_merge($_GET, $_POST);

        if(strlen($param) > 0) {
            $project = Project::with(['ikm', 'ukuran'])->where('url', '=', $param)->first();
            if($project != null) {
                $m = $project->toArray();
                $project_id = Arr::get($m, 'id');
                $project_nama = Arr::get($m, 'name');
                $project_url = Arr::get($m, 'url');
                $project_harga = Arr::get($m, 'price');
                $project_deskripsi = Arr::get($m, 'spesification');
                $owner = Arr::get($m, 'ikm');
                if($owner != null) {
                    $owner_id = $owner['id'];
                    $owner_nama = $owner['name'];
                }
                $ukuran = Arr::get($m, 'ukuran');
                if($ukuran != null) {
                    foreach($ukuran as $r) {
                        $ukurans[] = array(
                            'ukuran_id' => $r['pivot']['ukuran_id'],
                            'ukuran_nama' => $r['name'],
                            'qty' => $r['pivot']['qty']
                        );
                    }
                }
            }
        }

        if($request != null) {
            $amount = Arr::get($request, 'price');
            $amount_hidden = Arr::get($request, 'price_hidden');
            $message = Arr::get($request, 'message');

            if($errCode == 0) {
                if(strlen($amount) == 0) {
                    $errCode = 134;
                    $errMsg = "Harga required";
                }
            }

            if($errCode == 0) {
                $data = array(
                    'penjahit_id' => $penjahit_id,
                    'ikm_id' => $owner_id,
                    'code' => utils::generateOffer($project_id),
                    'project_id' => $project_id,
                    'type' => $type,
                    'offer_price' => $amount_hidden,
                    'note' => $message
                );
                $model = new Penawaran;
                $model->fill($data);
                $save = $model->save();
                if($save) {
                    $notif = array(
                        'name' => 'Project '.$project_nama.' success '.$type,
                        'description' => 'Project '.$project_nama.' telah sukses dilakukan penawaran oleh '.CMemberLogin::get('name'),
                        'type' => null,
                        'project_id' => $project_id,
                        'transaksi_id' => null,
                        'penawaran_id' => null,
                        'penjahit_id' => CMemberLogin::get('id'),
                        'penjahit_name' => CMemberLogin::get('name'),
                        'ikm_id' => $model->ikm_id,
                        'ikm_name' => \App\Models\Ikm::find($model->ikm_id)->name,
                    );
                    cnotif::create($notif);
                }
            }

            if($errCode > 0){
                DB::rollback();
                cmsg::add('error', $errMsg);
            }else {
                DB::commit();
                cmsg::add('success', 'Project '.$project_nama.' has been success to bid with price '.config('cart.currency')." ".$amount);
                return redirect(route('project.view', $project_url));
            }
        }

        $data['nama'] = $project_nama;
        $data['owner'] = $owner;
        $data['harga'] = $project_harga;
        $data['deskripsi'] = $project_deskripsi;
        $data['url'] = $project_url;
        $data['owner_nama'] = $owner_nama;
        $data['ukuran'] = $ukurans;
        $title = "";
        if(strlen($project_url) > 0)
            $title = "Bid Create";
        $data['title'] = $title;
        return view('front.project.bid', $data);
    }


    // public function nego($param = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $project_id = '';
    //     $ikm_id = '';
    //     $nama = '';
    //     $url = '';
    //     $harga = '';
    //     $penjahit_id = CMemberLogin::get('id');

    //     if(strlen($param) > 0) {
    //         try{
    //             $find = Project::where('status', '>', 0)->where('url', '=', $param)->first();
    //             if($find != null) {
    //                 $project_id = $find->id;
    //                 $ikm_id = $find->ikm_id;
    //                 $nama = $find->name;
    //                 $url = $find->url;
    //                 $harga = $find->price;
    //             }
    //         } catch(\Exception $e) {
    //             $errCode = 133;
    //             $errMsg = $e->getMessage();
    //         }
    //     }

    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $harga_nego = Arr::get($request, 'harga');

    //         if($errCode == 0) {
    //             if(strlen($harga_nego) == 0) {
    //                 $errCode = 1344;
    //                 $errMsg = "Harga required";
    //             }
    //         }

            // if($errCode == 0) {
            //     $chance = cdbutils::get_value("select min(chance) from offers where penjahit_id =".$penjahit_id." and type = 'nego'");
            //     $chances = $chance == null ? 3 : $chance - 1 ;
            // }
            // if($errCode == 0) {
            //     if($chances == 0) {
            //         $errCode = 121;
            //         $errMsg = "Sorry chances already exhausted";
            //     }
            // }

    //         if($errCode == 0) {
    //             DB::beginTransaction();
    //             try{
    //                 $s = cdbutils::get_value("select app_rate from setting where app_code='ek' limit 1");
    //                 $c = cdbutils::get_value("select min(chance) from offers where penjahit_id =".$penjahit_id." and type = 'nego'");
    //                 $setting = ($s == null ? 10 : $s);
    //                 $chance = ($c == null ? 3 : $c - 1);
    //                 $persen = (($setting * $chance) / 100);
    //                 $harga_penawaran = round(((($harga - $harga_nego) * $persen) + $harga_nego), 2);

    //                 $dt = array(
    //                     'penjahit_id' => $penjahit_id,
    //                     'ikm_id' => $ikm_id,
    //                     'project_id' => $project_id,
    //                     'type' => 'nego',
    //                     'offer_price' => $harga_nego,
    //                     'offer_price_system' => $harga_penawaran,
    //                     'rate' => $persen,
    //                     'chance' => $chance
    //                 );

    //                 $model = Penawaran::latest()
    //                             ->where('chance', '<>', 0)
    //                             ->where('status', '>', 0)
    //                             ->where('penjahit_id', '=', $penjahit_id)
    //                             ->where('type', '=', 'nego')
    //                             ->first();
    //                 if($model == null) {
    //                     $model = new Penawaran;
    //                 }
    //                 $model->fill($dt);
    //                 $save = $model->save();
    //                 if($save) {
    //                     $data = array(
    //                         'id' => $model->id,
    //                         'project_id' => $model->project_id,
    //                         'harga_project' => $harga,
    //                         'harga' => $model->offer_price,
    //                         'harga_sistem' => $model->offer_price_system,
    //                         'chance' => $model->chance,
    //                     );
    //                 }
    //             } catch(\Exception $e) {
    //                 $errCode = 111;
    //                 $errMsg = $e->getMessage();
    //             }

    //             if($errCode == 0) {
    //                 DB::commit();
    //             } else {
    //                 DB::rollback();
    //             }
    //         }
    //     }

    //     $response = array();
    //     if($errCode == 0) {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //         $response['data'] = $data;
    //     } else {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //     }
    //     return response()->json($response);
    // }

    // public function negoApprove() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $penjahit_id = CMemberLogin::get('id');

    //     if($errCode == 0) {
    //         if(strlen($penjahit_id) == 0) {
    //             $errCode = 11;
    //             $errMsg = "User ID required";
    //         }
    //     }

    //     if($errCode == 0) {

    //     }

    //     $response = array();
    //     if($errCode == 0) {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //         $response['data'] = $data;
    //     } else {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //     }
    //     return response()->json($response);
    // }

    // public function negoLast() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $kesempatan = 3;
    //     $harga_nego = '';
    //     $harga_penawaran = '';
    //     $arrLast = array();
    //     $penjahit_id = CMemberLogin::get('id');

    //     if($errCode == 0) {
    //         if(strlen($penjahit_id) == 0) {
    //             $errCode = 11;
    //             $errMsg = "User ID required";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $model = Penawaran::latest()
    //                     ->where('status', '>', 0)
    //                     ->where('penjahit_id', '=', $penjahit_id)
    //                     ->where('type', '=', 'nego')
    //                     ->first();
    //         if($model != null){
    //             $kesempatan = $model->chance;
    //             $harga = $model->offer_price;
    //             $harga_sistem = $model->offer_price_system;

    //             if($errCode == 0) {
    //                 if($kesempatan == 0) {
    //                     $errCode = 1455;
    //                     $errMsg = "Kesempatan habis";
    //                 }
    //             }

    //             if($errCode == 0) {
    //                 $arrLast = array(
    //                     'harga_nego' => round($harga, 2),
    //                     'harga_nego_sistem' => round($harga_sistem, 2)
    //                 );
    //             }
    //         }

    //         $data['kesempatan'] = $kesempatan;
    //         if(count($arrLast) > 0) {
    //             $data['last'] = $arrLast;
    //         }
    //     }

    //     $response = array();
    //     if($errCode == 0) {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //         $response['data'] = $data;
    //     } else {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //     }
    //     return response()->json($response);
    // }

    public function ikm_detail($id)
    {
        $data = array();
        $errCode = '';
        $errMsg = 0;
        $vendor_id = '';
        $rating = '';
        $name = '';
        $name_display = '';
        $alamat = '';
        $tanggal = '';
        $telepon = '';
        $gender = '';
        $image_url = '';

        if(strlen($id) > 0) {
            try{
                $user = Ikm::find($id);
                if($user != null) {
                    $u = $user->toArray();
                    $vendor_id = array_get($u, 'id');
                    $review = \App\Models\Review::where('ikm_id', '=', $vendor_id)->get();
                    $review_count = $review->count();
                    if($review != null) {
                        $total = 0;
                        foreach($review as $row) {
                            $total += $row->rating;
                            $rating = $total / $review_count;
                        }
                    }
                    $name = array_get($u, 'name');
                    $name_display = array_get($u, 'name_display');
                    $alamat = array_get($u, 'address');
                    $telepon = array_get($u, 'phone');
                    $tanggal = array_get($u, 'birthdate');
                    $tanggal = utils::formatDate($tanggal);
                    $gender = array_get($u, 'gender');
                    $image_url = array_get($u, 'image_url');
                }
            } catch(\Exception $e) {
                $errCode = 1414;
                $errMsg = $e->getMessage();
            }
        }

        $data['vendor_id'] = $vendor_id;
        $data['rating'] = $rating;
        $data['review'] = $review;
        $data['name'] = $name;
        $data['name_display'] = $name_display;
        $data['alamat'] = $alamat;
        $data['phone'] = $telepon;
        $data['birthdate'] = $tanggal;
        $data['gender'] = $gender == 1 ? "Laki-laki" : "Perempuan";
        $data['image_url'] = $image_url;
        $project = \App\Models\Project::where('status', '>', 0)->where('ikm_id', '=', $id)->get();
        $data['project'] = $project;
        $data['project_count'] = $project->count();
        return view('front.ikm', $data);
    }
}
