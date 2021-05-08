<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB, Auth;
use Illuminate\Support\Arr;
use App\Models\Ikm;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;

class UserUpdateProfileImage extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();

        $files = $_FILES;
        $profileImage = Arr::get($files, 'image_name');
        $file = request()->file('image_name');
        $user_id = Arr::get($request, 'id');

        if ($err_code == 0) {
            if (strlen($user_id) == 0) {
                $err_code = 1345;
                $err_message = 'User is required';
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
                $modelUser = Ikm::find($user_id);
                $modelUser->fill($dataUpdate);
                $modelUser->save();
            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Failed to update profile picture ' . $e->getMessage();
            }
        }

        $email = '';
        if ($err_code == 0) {
            $data_user = cdbutils::get_row('select * from ikm where id='.($user_id));
            $email = $data_user->email;
            $param = array(
                'user_id' => null,
                'before' => $data_user,
                'after' => $data,
            );
        }

        if ($err_code == 0) {
            DB::commit();
            //clog::activity($param, 'UpdateProfileImage', __("Update Image User [".$data_user->name."] Successfully Updated !"));
        } else {
            DB::rollback();
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}