<?php
namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Ikm;
use App\Models\Ukuran;
use DB, Auth;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use Lintas\libraries\CUserLogin;
use Lintas\libraries\CProject;
use Lintas\libraries\CApi\Exception as ApiException;

class ProjectController extends MasterController {
    public $filepaths = null;
    public function __construct() {
        $this->filepaths = "/uploads/project";
    }

    public function upload() {
        $errCode = 0;
        $errMsg = "";
        $fileArr = array();
        $path = public_path($this->filepaths);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if($errCode == 0) {
            $file = request()->file('file');
            $fileName = $file->getClientOriginalName();
            $fileMime = $file->getMimeType();
            $startTime = microtime(true);

            if($errCode == 0) {
                if(strlen($fileName) == 0) {
                    $errCode = 1456;
                    $errMsg = "Filename empty";
                }
            }
        }

        if($errCode == 0) {
            $fileName = trim($fileName);
            $moved = $file->move($path, $fileName);
            if($moved) {
                $fileArr = array(
                    'image_name' => $fileName,
                    'relative_path' => asset('public'.$this->filepaths.'/'.$fileName),
                    'absolute_path' => str_replace('', '', realpath($path.'/'.$fileName))
                );
            }
        }

        $response = array();
        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $fileArr;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response, 200);
    }

    public function delete() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        $file = "";

        if($request != null) {
            $file = Arr::get($request, 'file');

            if($errCode == 0) {
                if(strlen($file) == 0) {
                    $errCode = 1111;
                    $errMsg = "File required";
                }
            }

            if($errCode == 0) {
                $abs_path = public_path($this->filepaths);
                $path = str_replace('', '', realpath($abs_path.'/'.$file));
                if (file_exists($path)) {
                    unlink($path);
                }
                $model = ProjectImage::where('image_name', '=', basename($file))->first();
                if($model != null) {
                    $deleted = $model->delete();
                    if($deleted) {
                        $data = array('message' => "Image ".$file." success deleted");
                    }
                }
            }

        }

        $response = array();
        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response, 200);
    }

    // public function init() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $result = array();
    //     $id = '';
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $id = Arr::get($request, 'id');
    //     }
    //     if($errCode == 0) {
    //         $model = ProjectImage::where('status', '>', 0)->where('project_id', '=', $id)->get();
    //         if($model != null) {
    //             foreach($model as $rows) {
    //                 $obj['name'] = $rows->image_name;
    //                 $obj['url'] = $rows->image_url;
    //                 $abs_path = public_path($this->filepaths);
    //                 $path = str_replace('', '', realpath($abs_path.'/'.$rows->image_name));
    //                 $obj['size'] = filesize($path);
    //                 $result[] = $obj;
    //             }
    //         }
    //     }
    //     $json = array();
    //     if($errCode == 0) {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //         $json['data'] = $result;
    //     } else {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //     }
    //     return response()->json($json, 200);
    // }

    public function index() {
        return view('admin.master.project.index');
    }

    public function show() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $auth = \Auth::guard('admin')->user();
        $ikm_id = ($auth->ikm_id == null ? '' : $auth->ikm_id);

        if($errCode == 0) {
            $modelProject = Project::where('status', '>', 0);
            if($ikm_id != null)
                $modelProject = $modelProject->whereRaw("ikm_id = '{$ikm_id}'");
            $modelProject = $modelProject->get();
            if($modelProject != null) {
                $project = $modelProject->toArray();
                if($project != null) {
                    foreach($project as $row) {
                        $data[] = array(
                            'id' => Arr::get($row, 'id'),
                            'name' => Arr::get($row, 'name'),
                            'code' => Arr::get($row, 'code'),
                            'price' => Arr::get($row, 'price'),
                            'created_at' => (string)Arr::get($row, 'created_at'),
                            'updated_at' => (string)Arr::get($row, 'updated_at'),
                            'status' => Arr::get($row, 'status'),
                        );
                    }
                }
            }
        }

        $array = array();
        if($errCode == 0) {
            if(count($data) > 0) {
                foreach($data as $rows){
                    $array['data'][] = $rows;
                }
            } else {
                $array['data'] = array();
            }
        }
        return response()->json($array, 200);
    }

    public function create() {
        return $this->edit();
    }

    public function edit($id = null) {
        $data = array();
        $ikm = Ikm::where('status', '>', 0)->get()->toArray();
        $penunjuk = $ikm;
        $penunjuk_id = '';
        $session = Auth::guard('admin')->user();
        if($session != null) {
            $session_id = $session->id;
            $session_ikm_id = $session->ikm_id;
            $session_name = $session->username;
        }
        $ukuran = Ukuran::where('status', '>', 0)->get()->toArray();

        $errCode = 0;
        $errMsg = '';
        $request = array_merge($_GET, $_POST);
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
        $size_guide_anak = '';
        $size_guide_dewasa = '';
        $tanggal = '';
        $image = array();
        $ukuranArr = array();

        if(strlen($id) > 0) {
            try{
                $projects = Project::with(['images','ukuran'])
                            ->whereId($id)
                            ->get()->toArray();
                if(count($projects) > 0) {
                    foreach($projects as $project) {
                        $kode = Arr::get($project, 'code');
                        $nama = Arr::get($project, 'name');
                        $url = Arr::get($project, 'url');
                        $ikm_id = Arr::get($project, 'ikm_id');
                        $harga = Arr::get($project, 'price');
                        $tanggal = Arr::get($project, 'published_date');
                        $tanggal = utils::formatDate($tanggal);
                        $rentang = Arr::get($project, 'deadline');
                        $video = Arr::get($project, 'video_url');
                        $size_guide_anak = Arr::get($project,'size_guide_anak');
                        $size_guide_dewasa = Arr::get($project,'size_guide_dewasa');
                        //$size_guide = Arr::get($project, 'size_guide_url');
                        $deskripsi = Arr::get($project, 'description');
                        $spesifikasi = Arr::get($project, 'spesification');
                        $images = Arr::get($project, 'images');
                        if(count($images) > 0) {
                            foreach($images as $rows) {
                                $image[] = array(
                                    'name' => $rows['image_name'],
                                    'original_name' => $rows['original_image_name'],
                                    'url' => $rows['image_url']
                                );
                            }
                        }

                        $ukuranArr = array();
                        $temp_project_ukuran = \App\Models\ProjectUkuran::where('project_id','=',$id)->get();
                        if($temp_project_ukuran != null) {
                            foreach($temp_project_ukuran as $row_project_ukuran) {
                                $ukuranArr[] = array(
                                    'project_id' => $row_project_ukuran->project_id,
                                    'ukuran_id' => $row_project_ukuran->ukuran_id,
                                    'qty' => $row_project_ukuran->qty
                                );
                            }
                        }
                        // $project_ukuran = Arr::get($project, 'ukuran');
                        // if(count($project_ukuran) > 0) {
                        //     foreach($project_ukuran as $row) {
                        //         $ukuranArr[] = array(
                        //             'ukuran_id' => $row['pivot']['ukuran_id'],
                        //             'qty' => $row['pivot']['qty']
                        //         );
                        //     }
                        // }

                    }
                }
            } catch(\Exception $ex) {
                $errCode = 414;
                $errMsg = $ex->getMessage();
            }
        }

        if($request != null) {
            $ikm_id = $session_ikm_id;
            if($session_ikm_id == null && $session_ikm_id == '') {
                $ikm_id = Arr::get($request, 'ikm_id');
            }
            $kode = Arr::get($request, 'project_code');
            $nama = Arr::get($request, 'project_name');
            $url = Arr::get($request, 'url');
            $tanggal = Arr::get($request, 'project_published_date');
            $harga = Arr::get($request, 'project_price');
            $rentang = Arr::get($request, 'project_deadline');
            $video = Arr::get($request, 'project_video');
            $size_guide_anak = $_FILES;
            $size_guide_dewasa = $_FILES;
            //$video = Arr::get($request, 'project_video');
            $deskripsi = Arr::get($request, 'project_description');
            $spesifikasi = Arr::get($request, 'project_spesification');
            $image = Arr::get($request, 'image');
            $project_ukuran = Arr::get($request, 'projectUkuran');
            $project_ukuran_qty = Arr::get($request, 'projectUkuranValue');

            if($errCode == 0) {
                $param = array();
                $param['ikm_id'] = $ikm_id;
                $param['code'] = $kode;
                $param['name'] = $nama;
                $param['url'] = $url;
                $param['published_date'] = $tanggal;
                $param['deadline'] = $rentang;
                $param['price'] = utils::unformatCurrency($harga);
                $param['video'] = $video;
                $param['size_guide_anak'] = $size_guide_anak;
                $param['size_guide_dewasa'] = $size_guide_dewasa;
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
                if(strlen($id) > 0) {
                    $param['id'] = $id;
                }
                $result = false;
                try{
                    $result = CProject::projectUpdate($param);
                } catch(ApiException $ex) {
                    $errCode = 552;
                    $errMsg = $ex->getMessage();
                } catch(\Exception $ex) {
                    $errCode++;
                    $errMsg = $ex->getMessage();
                }
            }

            if($errCode == 0) {
                $msg = " Success insert";
                if(strlen($id) > 0) {
                    $msg = " Success modified";
                }
                cmsg::add('success', $nama.$msg);

                //
                $ikm = CUserLogin::get('id');
                if($ikm != null)
                    return redirect(route('admin.dashboard'));
                else
                    return redirect(route('admin.master.project'));
            } else {
                cmsg::add('error', $errMsg);
            }
        }

        $data['ikm'] = $ikm;
        $data['ukuran'] = $ukuran;
        $data['penunjuk'] = $penunjuk;
        $data['penunjuk_id'] = $penunjuk_id;
        $data['ikm_id'] = $ikm_id;
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
        $data['size_guide_anak'] = $size_guide_anak;
        $data['size_guide_dewasa'] = $size_guide_dewasa;
        $data['id'] = $id;
        $data['session_id'] = $session_id;
        $data['session_ikm_id'] = $session_ikm_id;
        $data['session_name'] = $session_name;
        $title = 'Tambah Project';
        if(strlen($id) > 0) {
            $title = 'Update Project';
        }
        $data['title'] = $title;
        return view('admin.master.project.detail', $data);
    }



}