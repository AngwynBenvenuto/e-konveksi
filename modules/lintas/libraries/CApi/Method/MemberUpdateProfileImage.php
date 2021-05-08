<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB, Auth;
use Illuminate\Support\Arr;
use App\Models\Penjahit;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;

class MemberUpdateProfileImage extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();

        $files = $_FILES;
        $profileImage = Arr::get($files, 'image_name');
        $file = request()->file('image_name');
        $member_id = Arr::get($request, 'id');

        if ($err_code == 0) {
            if (strlen($member_id) == 0) {
                $err_code = 1345;
                $err_message = 'Member is required';
            }
        }

        if ($err_code == 0) {
            DB::beginTransaction();
            try {
                $path = public_path('uploads/profile/');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $dataUpdate = array();
                $filename = Arr::get($profileImage, 'name');
                if (strlen($filename) > 0) {
                    $file->move($path, $filename);
                    $fileNameGenerated = trim($file->getClientOriginalName());

                    $imageUrl = asset('public/uploads/profile/'.$fileNameGenerated);
                    $dataUpdate["image_name"] = $fileNameGenerated;
                    $dataUpdate["image_url"] = $imageUrl;
                }
                $dataUpdate["updated_at"] = date("Y-m-d H:i:s");
                $modelMember = Penjahit::find($member_id);
                $modelMember->fill($dataUpdate);
                $modelMember->save();
            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Failed to update profile picture ' . $e->getMessage();
            }
        }

        $email = '';
        if ($err_code == 0) {
            $data_member = cdbutils::get_row('select * from penjahit where id='.($member_id));
            $email = $data_member->email;
            $param = array(
                'user_id' => null,
                'before' => $data_member,
                'after' => $data,
            );
        }

        if ($err_code == 0) {
            DB::commit();
            //clog::activity($param, 'UpdateProfileImage', __("Update Image Member [".$data_member->name."] Successfully Updated !"));
        } else {
            DB::rollback();
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}