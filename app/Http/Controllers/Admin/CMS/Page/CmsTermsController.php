<?php
namespace App\Http\Controllers\Admin\CMS\Page;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Illuminate\Support\Arr;
use Lintas\helpers\cmsg;

class CmsTermsController extends AdminController {
    public function create() {
        return $this->edit();
    }

    public function edit($id = null) {
        $errCode = 0;
        $errMessage = '';
        $data = array();
        $content = '';
        $request = array_merge($_GET, $_POST);

        if($content === null) {
            try {
                $cmsPageModel = CmsPage::where('page_type', '=', 'term_condition')->first();
                if ($cmsPageModel != null) {
                    $content = $cmsPageModel->content;
                }
            } catch (\Exception $ex) {
                $errCode = 145;
                $errMessage = $ex->getMessage();
            }
        }

        if($request != null) {
            $content = Arr::get($request, 'content');
            
            try {
                $cmsPageModel = CmsPage::where('page_type', '=', 'term_condition')->first();
                if ($cmsPageModel != null) {
                    $content = $cmsPageModel->content;
                }
                if ($cmsPageModel == null) {
                    $cmsPageModel = new CmsPage;
                    $cmsPageModel->page_type = 'term_condition';
                    $cmsPageModel->title = 'Terms & Condition';
                    $cmsPageModel->created_at = date('Y-m-d H:i:s');
                }
                $cmsPageModel->updated_at = date('Y-m-d H:i:s');
                $cmsPageModel->content = $content;
                $cmsPageModel->is_edited = 1;
                $cmsPageModel->save();
            } catch(\Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }

            if ($errCode == 0) {
                cmsg::add('success', __('Terms berhasil diperbarui'));
            } else {
                cmsg::add('error', $errMessage);
            }
        }

        $data['title'] = "Terms & Condition";
        $data['content'] = $content;
        return view('admin.cms.page.privacy', $data);
    }
}