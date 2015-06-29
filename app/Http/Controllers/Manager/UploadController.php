<?php

namespace App\Http\Controllers\Manager;

use App\Good;
use App\ImageMd5;
use Dearmadman\ImageTool\ImageTool;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    public function __construct()
    {
        $this->middleware('manager');
    }

    public function UploadImages(Request $request)
    {
        $target = $this->UploadImageHandler($request, "file");
        return $target ? $target : 'false';
    }

    public function GoodGallery(Request $request)
    {
        $method = $request->has('method') ? $request->input('method') : false;
        $id=$request->input('id');
        if($id){
            /*  illegal manager */
            $good=new Good();
            if(!$good->getGood($request->user()->manager_id,$id)){
                return 'false';
            }
        }
        $session=$method.'_image_gallery'.$id;
        if (!$method) {
            return 'false';
        }
        /* determine if type is destroy */

        if ($request->has('destroy')) {
            $file_name = $request->input('file_name');
            $file_name=trim($file_name,'/');
            $image_gallery = session($session);
            if ($image_gallery) {
                if (array_key_exists($file_name, $image_gallery)) {
                    unset($image_gallery[$file_name]);
                    session([$session => $image_gallery]);
                    session()->save();
                }
            }
            return 'true';
        }

        $target = $this->UploadImageHandler($request, "file");
        $image_tool = ImageTool::GetInstance();
        if ($target) {
            /* compress image-gallery */
            if (!file_exists($target)) {
                return "file exists failed";
            }
            $configs = config('image.compress_config');
            $gallery_now[$target] = ['image' => $target];
            foreach ($configs as $k => $v) {
                $arr = [
                    'width' => $v['width'],
                    'height' => $v['height'],
                    'cover_img' => false,
                    'jpeg_quality' => config('image.compress_rate')
                ];
                $image_tool->SetConfig($arr);
                $res = $image_tool->GetImageFromString($target, $k);
                $gallery_now[$target] = array_merge($gallery_now[$target], [$k => $res]);
            }
            $image_gallery = session($session);
            $image_gallery[$target] = $gallery_now[$target];
            session([$session => $image_gallery]);
            return $target;
        }
        return 'GoodGallery false';
    }

    public function CompressHandler($target)
    {
        $image_tool = ImageTool::GetInstance();
        if ($target) {
            /* compress image-gallery */
            if (!file_exists($target)) {
                return "file exists failed";
            }
            $configs = config('image.compress_config');
            foreach ($configs as $k => $v) {
                $arr = [
                    'width' => $v['width'],
                    'height' => $v['height'],
                    'cover_img' => false,
                    'jpeg_quality' => config('image.compress_rate')
                ];
                $image_tool->SetConfig($arr);
                $res = $image_tool->GetImageFromString($target, $k);
                if (!$res) {
                    return false;
                }
            }
        }
        return true;
    }

    public function UploadImagesCkeditor(Request $request)
    {
        $target = $this->UploadImageHandler($request, "upload");
        if ($target) {
            return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(" . $request->input('CKEditorFuncNum') . ",'/" . $target . "','');</script>";
        }
        return "<font color=\"red\"size=\"2\">*文件格式不正确（必须为.jpg/.gif/.bmp/.png文件）</font>";
    }


    public function UploadImageHandler($request, $fileName)
    {
        $file = $request->hasFile($fileName);
        if ($file) {
            $file = $request->file($fileName);
            /* Determine file's mine is legal  */
            $files_access_mime_type = ['image/jpeg', 'image/png', 'image/gif'];
            $ext = ['jpg', 'png', 'gif'];
            $mime_type = $file->getMimeType();
            if (!in_array($mime_type, $files_access_mime_type)) {

                return false;
            } else {
                $ext = $ext[array_search($mime_type, $files_access_mime_type)];
            }
            /* Detemine if is manager */
            $auth = \Auth::user();
            if (!$auth->isManager()) {
                return false;
            }
            /* move images to destination */
            $file_name = md5_file($file->getRealPath()) . '.' . $ext;
            $image_md5 = new ImageMd5();
            if ($img = $image_md5->hasFile($file_name)) {
                return config('image.storage_path') . $img->date_dir.'/' . $file_name;
            }
            $date_dir = date("Ymd") . '/';
            $path = config('image.storage_path') . $date_dir;
            $target = $file->move($path, $file_name);
            if ($target) {
                $target = $path . $file_name;
                /* insert Md5 file info */
                $image_md5->date_dir = trim($date_dir,'/');
                $image_md5->file_name = $file_name;
                $image_md5->save();
                if (config('image.compress_config_enable')) {
                    /* compress image */
                    $image_tool = ImageTool::GetInstance();
                    $arr = [
                        'jpeg_quality' => config('image.compress_rate'),
                        'cover_img' => config('image.compress_cover'),
                    ];
                    $image_tool->SetConfig($arr);
                    $image_tool->GetImageFromString($target, 'img');
                }


            }
            return $target;
        }
        return false;
    }

}
