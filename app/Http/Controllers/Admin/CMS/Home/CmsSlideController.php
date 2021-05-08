<?php
namespace App\Http\Controllers\Admin\CMS\Home;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\CmsSlide;
use Lintas\helpers\cdbutils;
use Lintas\helpers\cmsg;
use Illuminate\Support\Arr;

class CmsSlideController extends AdminController {
    public $filepaths = null;
    public function __construct() {
        $this->filepaths = "/uploads/cms";
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
                $model = CmsSlide::where('image_name', '=', basename($file))->first();
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

    public function init() {
        $errCode = 0;
        $errMsg = "";
        $result = array();
        $model = CmsSlide::where('status', '>', 0)->get();
        if($model != null) {
            foreach($model as $rows) {
                $obj['name'] = $rows->image_name;
                $obj['url'] = $rows->image_url;
                $abs_path = public_path($this->filepaths);
                $path = str_replace('', '', realpath($abs_path.'/'.$rows->image_name));
                $obj['size'] = filesize($path);
                $result[] = $obj;
            }
        } else {
            $errCode = 145;
            $errMsg = "Data empty";
        }
        
        $json = array();
        if($errCode == 0) {
            $json['errCode'] = $errCode;
            $json['errMsg'] = $errMsg;
            $json['data'] = $result;
        } else {
            $json['errCode'] = $errCode;
            $json['errMsg'] = $errMsg;
        }
        return response()->json($json, 200);
    }

    public function create() {
        return $this->edit();
    }

    public function edit($id = null) {
        $errCode = 0;
        $errMessage = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $path = "";

        if($request != null) {
            $image = Arr::get($request, 'image');
            try{
                if($image != null) {
                    for($i = 0; $i < count($image); $i++) {
                        $fileName = $image[$i];
                        $filePath = asset('public'.$this->filepaths.'/'.$image[$i]);
                        $dataFile = array(
                            'image_name' => $fileName,
                            'image_url' => $filePath,
                            'status' => 1,
                        );
                        $model = new CmsSlide;
                        $model->fill($dataFile);
                        $model->save();
                    }
                } 
            } catch(\Exception $ex) {
                $errCode = 1444;
                $errMessage = $ex->getMessage();
            }

            if ($errCode == 0) {
                cmsg::add('success', __('Slide berhasil diperbarui'));
            } else {
                cmsg::add('error', $errMessage);
            }
        } 

        $data['title'] = "CMS SlideShow";
        return view('admin.cms.home.slide', $data);
    }
    
}