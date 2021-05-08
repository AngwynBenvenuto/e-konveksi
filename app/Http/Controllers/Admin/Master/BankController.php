<?php 
namespace App\Http\Controllers\Admin\Master;
use App\Http\Controllers\Admin\MasterController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Bank;
use DB;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;

class BankController extends MasterController {
    public function index() {
        return view('admin.master.bank.index');
    }
    
    public function show() {
        $errCode = 0;
        $errMsg = "";
        $array = array();
        $bank = array();
            
        if($errCode == 0) {
            $modelBank = Bank::where('status', '>', 0)->get();
            if($modelBank != null) {
                $bank = $modelBank->toArray();
                if($bank != null) {
                    foreach($bank as $row) {
                        $data[] = array(
                            'id' => Arr::get($row, 'id'),
                            'name' => Arr::get($row, 'name'),
                            'description' => Arr::get($row, 'description'),
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
        
        $nama = '';
        $description = '';
        $request = array_merge($_GET, $_POST);
        $errCode = 0;
        $errMsg = '';
        
        if(strlen($id) > 0) {
            try{
                $modelBank = Bank::find($id);
                if($modelBank != null) {
                    $bank = $modelBank->toArray();
                    $nama = Arr::get($bank, 'name');
                    $description = Arr::get($bank, 'description');
                } else {
                    $errCode = 454;
                    $errMsg = "Bank not found";
                }
            } catch(\Exception $ex) {
                $errCode++;
                $errMsg = "Error ".$ex->getMessage();
            }
        }

        if($request != null) {
            $nama = Arr::get($request, 'bank_nama');
            $description = Arr::get($request, 'bank_deskripsi');
            if($errCode == 0) {
                if(strlen($nama) == 0) {
                    $errCode = 145;
                    $errMsg = "Nama required";
                }
            }

            DB::beginTransaction();
            if($errCode == 0){
                $param = array();
                $param['name'] = $nama;
                $param['description'] = $description;
                if (strlen($id) > 0) {
                    $param['id'] = $id;
                }

                try {
                    $bank = Bank::find($id);
                    if(strlen($id) == 0) {
                        $bank = new Bank;
                    }
                    $bank->fill($param);
                    $bank->save();
                } catch(\Exception $e) {
                    $errCode = 4245;
                    $errMsg = $e->getMessage();
                }
            }

            if($errCode == 0) {
                DB::commit();
                $msg = " Success insert";
                if(strlen($id) > 0) {
                    $msg = " Success modified";
                }
                cmsg::add('success', $nama.$msg);
                sleep(5);
                return redirect(route('admin.master.bank'));
            } else {
                DB::rollback();
                cmsg::add('error', $errMsg);
            }
        }
       
        $data['nama'] = $nama;
        $data['description'] = $description;
        $title = 'Tambah Bank';
        if (strlen($id) > 0) {
            $title = 'Update Bank';
        }
        $data['title'] = $title;
        return view('admin.master.bank.detail', $data);
    }

   
}