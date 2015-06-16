<?php

    namespace App\Http\Controllers\Manager;

    use App\ImageMd5;
    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;

    class UploadController extends Controller
    {

        public function __construct ()
        {
            $this->middleware ('manager');
        }

        public function UploadImages (Request $request)
        {
            $file = $request->hasFile ("file");
            if ($file) {
                $file = $request->file ("file");
                /* Determine file's mine is legal  */
                $files_access_mime_type = ['image/jpeg' , 'image/png' , 'image/gif'];
                $ext = ['jpg' , 'png' , 'gif'];
                $mime_type = $file->getMimeType ();
                if ( ! in_array ($mime_type , $files_access_mime_type)) {
                    return "false";
                } else {
                    $ext = $ext[ array_search ($mime_type , $files_access_mime_type) ];
                }
                /* Detemine if is manager */
                $auth = \Auth::user ();
                if ( ! $auth->isManager ()) {
                    return "false";
                }
                /* move images to destination */
                $file_name = md5_file ($file->getRealPath ()) . '.' . $ext;
                $image_md5 = new ImageMd5();
                if ($img = $image_md5->hasFile ($file_name)) {
                    return config ('image.storage_path') . $img->date_dir . $file_name;
                }
                $data_dir = date ("Ymd") . '/';
                $path = config ('image.storage_path') . $data_dir;
                $target = $file->move ($path , $file_name);
                if ($target) {
                    $target = $path . $file_name;
                    /* insert Md5 file info */
                    $image_md5->date_dir = $data_dir;
                    $image_md5->file_name = $file_name;
                    $image_md5->save ();
                }
                return $target;
            }
            return "false";
        }
    }
