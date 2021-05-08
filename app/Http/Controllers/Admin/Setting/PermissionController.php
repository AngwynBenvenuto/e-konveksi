<?php
namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class PermissionController extends AdminController {
    public function __construct(){
    }
    
    public function index() {
        return view('admin.setting.access.permission.index');
    }

    //
    public function create() {
        return $this->edit();
    }

    //
    public function edit($id = null) {

    }
}