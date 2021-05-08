<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lintas\libraries\CMemberLogin;
use App\Models\Project;
use App\Models\CmsSlide;

class HomeController extends Controller {

    public function index() {
        $data = array();
        $slides = CmsSlide::where('status', '>', 0)->get();
        $project = Project::inRandomOrder()
                    ->where('status', '>', 0);
        // if(CMemberLogin::get('id') != null) {
        //     $checkmodel = Project::where('tailor', '=', CMemberLogin::get('id'))->get();
        //     if($checkmodel->count() == 0) {
        //         $project = $project->whereNull('tailor')
        //                         >where('is_project_private','<>', 1);
        //     } else {
        //         $project = $project->where('tailor', '=', CMemberLogin::get('id'))
        //                         ->where('is_project_private','=',1);
        //     }
        // } 
                    // ->where('is_project_private','<>',1)
                    // ->orWhere('tailor', '=', CMemberLogin::get('id'))
        $project = $project->get();

        $data['slides'] = $slides;
        $data['project'] = $project;
        return view('front.dashboard', $data);
    }

    public function testdirect() {
        // $param = array();
        // $param['invoice_number'] = "PIAU04-0185/XII/SI/2019";
        // return CCurl::instance()->execute('https://erp56.lnjlogistics.com:14443/evy/job/checkMarketRelation', $param);

        // $param = array();
        // $param['name'] = "fff";
        // $param['name_display'] = "fz";
        // $param['tanggal_lahir'] = "2019-12-01";
        // $param['jenis_kelamin'] = 0;
        // $param['nomor_telepon'] = "13145";
        // $param['id'] = "2";
        //return CMember::updateProfile($param);
    }

}