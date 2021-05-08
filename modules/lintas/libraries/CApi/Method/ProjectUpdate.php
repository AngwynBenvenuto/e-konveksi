<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;
use Lintas\helpers\utils;
use App\Models\Project;
use App\Models\ProjectUkuran;

class ProjectUpdate extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $request = $this->request();
        $id = Arr::get($request, 'id');
        $qr_code = Arr::get($request, 'qr_code');
        $ikm_id = Arr::get($request, 'ikm_id');
        $kode = Arr::get($request, 'code');
        $url = Arr::get($request, 'url');
        $nama = Arr::get($request, 'name');
        $tanggal = Arr::get($request, 'published_date');
        $rentang = Arr::get($request, 'deadline');
        $video = Arr::get($request, 'video');
        $penjahit = Arr::get($request, 'tailor_id');
        $guide_anak = $_FILES;
        $size_guide_anak = Arr::get($guide_anak, 'guide_anak');
        $file_anak = request()->file('guide_anak');
        $guide_dewasa = $_FILES;
        $size_guide_dewasa = Arr::get($guide_dewasa, 'guide_dewasa');
        $file_dewasa = request()->file('guide_dewasa');
        $deskripsi = Arr::get($request, 'description');
        $spesifikasi = Arr::get($request, 'spesification');
        $image = Arr::get($request, 'image');
        $project_ukuran = Arr::get($request, 'project_ukuran');
        $harga = Arr::get($request, 'price');
        $harga = utils::unformatCurrency(utils::formatCurrency($harga));
        $size_guide_anak_url = $size_guide_dewasa_url = '';
        $is_project_private = Arr::get($request,'is_project_private');

        // $array_month = array();
        // for($i = 1; $i <= 12; $i++) {
        //     $array_month[] = $i;
        // }

        if($err_code == 0) {
            if(strlen($ikm_id) == 0) {
                $err_code = 12;
                $err_message = "Ikm ID required";
            }
            else if(strlen($nama) == 0) {
                $err_code = 13;
                $err_message = "Name required";
            }
            else if(strlen($tanggal) == 0) {
                $err_code = 14;
                $err_message = "Date required";
            }
            // else if(!in_array($rentang, $array_month)) {
            //     $err_code = 15;
            //     $err_message = "Invalid month, please insert 1-12 only";
            // }
        }

        if($err_code == 0) {
            if(strlen($kode) == 0) {
                $kode = utils::generateProjectUnique($nama);
            }
            if(strlen($qr_code) == 0) {
                $qr_code = utils::generateQrCode($kode);
            }
            if(strlen($url) == 0) {
                $url = utils::generateUrl($nama, strlen($nama));
            }
            //upload image
            if($guide_anak != null || $guide_dewasa != null) {
                $path = public_path('uploads/panduan/');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                if($size_guide_anak != null) {
                    $filenameAnak = Arr::get($size_guide_anak, 'name');
                    if(strlen($filenameAnak) > 0) {
                        $file_anak->move($path, $filenameAnak);
                        $fileNameGeneratedAnak = trim($file_anak->getClientOriginalName());
                        $size_guide_anak_url = asset('public/uploads/panduan/'.$fileNameGeneratedAnak);
                    }
                }
                if($size_guide_dewasa != null) {
                    $filenameDewasa = Arr::get($size_guide_dewasa, 'name');
                    if(strlen($filenameDewasa) > 0) {
                        $file_dewasa->move($path, $filenameDewasa);
                        $fileNameGeneratedDewasa = trim($file_dewasa->getClientOriginalName());
                        $size_guide_dewasa_url = asset('public/uploads/panduan/'.$fileNameGeneratedDewasa);
                    }
                }
            }


            DB::beginTransaction();
            try{
                $param = array();
                $param['code'] = $kode;
                $param['qr_code'] = $qr_code;
                $param['ikm_id'] = $ikm_id;
                $param['name'] = $nama;
                $param['deadline'] = $rentang;
                $param['published_date'] = $tanggal;
                $param['price'] = $harga;
                $param['video_url'] = $video;
                $param['size_guide_anak'] = $size_guide_anak_url;
                $param['size_guide_dewasa'] = $size_guide_dewasa_url;
                $param['url'] = $url;
                $param['spesification'] = $spesifikasi;
                $param['description'] = $deskripsi;
                if(strlen($penjahit) > 0) {
                    $param['tailor'] = $penjahit;
                    $param['is_signed_tailor'] = 1;
                }

                if(strlen($is_project_private) > 0) {
                    $param['is_project_private'] = $is_project_private;
                }

                $m = Project::find($id);
                if(strlen($id) == 0) {
                    $m = new Project;
                }
                $m->fill($param);
                $saved = $m->save();
                if($saved) {
                    //insert to ukuran & image
                    if($image != null) {
                        if(count($image) > 0) {
                            $del = DB::select(DB::raw("DELETE FROM project_image WHERE project_id = '{$m->id}'"));
                            $param = array();
                            for($i = 0; $i < count($image); $i++) {
                                $img = array(
                                    'project_id' => $m->id,
                                    'image_name' => $image[$i],
                                    'original_image_name' => null,
                                    'image_url' => asset('public/uploads/project/'.$image[$i])
                                );
                                $insertpi=new \App\Models\ProjectImage;
                                $insertpi->fill($img);
                                $insertpi->save();

                                //$path = asset('public/uploads/project/'.$image[$i]);
                                // $img = new \App\Models\ProjectImage([
                                //     'project_id' => $m->id,
                                //     'image_name' => $image[$i],
                                //     'original_image_name' => null,
                                //     'image_url' => $path
                                // ]);
                                // if(!file_exists($path)) {
                                //     //$m->images()->delete();
                                //     $m->images()->save($img);
                                // } else {
                                //     $m->images()->update($img);
                                // }
                            }
                        }
                    }

                    if($project_ukuran != null) {
                        if(count($project_ukuran) > 0) {
                            $del = DB::select(DB::raw("DELETE FROM project_ukuran WHERE project_id = '{$m->id}'"));
                            $param = array();
                            for($i = 0; $i < count($project_ukuran); $i++) {
                                $project_id = $m->id;
                                $ukuran_id = (int)$project_ukuran[$i]['ukuran_id'];
                                $qty = (int)$project_ukuran[$i]['qty'];

                                //dd($param);
                                // $mo = ProjectUkuran::where('ukuran_id', '=', $ukuran_id)
                                //             ->where('project_id', '=', $project_id)
                                //             ->first();
                                //if(strlen($id) == 0)
                                $mo = new ProjectUkuran;
                                $mo->fill(
                                    array(
                                        'project_id' => $project_id,
                                        'ukuran_id' => $ukuran_id,
                                        'qty' => $qty,
                                    )
                                );
                                $mo->save();
                                // $ukuran_temp[] = array(
                                //     'project_id' => $m->id,
                                //     'ukuran_id' => $project_ukuran[$i]['ukuran_id'],
                                //     'qty' => $project_ukuran[$i]['qty']
                                // );
                            }


                            // if(strlen($id) > 0)
                            //     $m->ukuran()->sync($ukuran_temp);
                            // else
                            //     $m->ukuran()->attach($ukuran_temp);
                        }
                    }


                    DB::commit();
                }
            } catch(\Exception $ex) {
                $err_code = 1444;
                $err_message = $ex->getMessage();
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}