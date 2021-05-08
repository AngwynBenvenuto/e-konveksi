<?php
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;

class PagesController extends Controller {
    public function intro() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'intro')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "Pengenalan";
        $data['content'] = $content;
        return view('front.page.intro', $data);
    }

    public function faq() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'faq')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "FAQ";
        $data['content'] = $content;
        return view('front.page.faq', $data);
    }

    public function terms() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'terms_condition')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "Syarat dan Ketentuan";
        $data['content'] = $content;
        return view('front.page.terms', $data);
    }

    public function privacy() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'privacy_policy')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "Kebijakan Privasi";
        $data['content'] = $content;
        return view('front.page.privacy', $data);
    }

    public function contact() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'contact_us')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "Kontak Kami";
        $data['content'] = $content;
        return view('front.page.contact', $data);
    }

    public function about() {
        $data = array();
        $content = '';

        if($content == null) {
            $cmsPageModel = CmsPage::where('page_type', '=', 'about_us')->first();
            if ($cmsPageModel != null) {
                $content = $cmsPageModel->content;
            }
        }

        $data['title'] = "Tentang Kami";
        $data['content'] = $content;
        return view('front.page.about', $data);
    }

    
}