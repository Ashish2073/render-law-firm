<?php
use Intervention\Image\Laravel\Facades\Image;


if (!function_exists('havePermission')) {
    function havePermission($role = "", $permission_name)
    {
        if (empty($role)) {
            return false;
        }



        $permissions = $role->permissions()->get();



        foreach ($permissions as $permission) {
            if ($permission->name == $permission_name) {
                return true;
            }
        }


        return false;
    }

}

if (!function_exists('hasPermissionForRoles')) {
    function hasPermissionForRoles($permissionName, $roleNames)
    {


        if (count($roleNames) == 0) {
            return false;
        }
        if (in_array("admin", $roleNames)) {
            return true;
        }
        $roleIds = DB::table('roles')->whereIn('name', $roleNames)->pluck('id');
        $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');



        $count = DB::table('role_has_permissions')
            ->whereIn('role_id', $roleIds)
            ->where('permission_id', $permissionId)
            ->count();




        if ($count > 0) {

            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('loggedGuardUserDetail')) {
    function loggedGuardUserDetail()
    {

        $details = (object) [
            'logged_id' => null,
            'logged_name' => null,
            'logged_email' => null,
            'logged_profile_image' => null,
            'logged_profile_image_url' => null,
            'logged_guard' => null,
        ];

        if (auth('customer')->check()) {
            $details->logged_id = auth('customer')->user()->id;
            $details->logged_name = auth('customer')->user()->name;
            $details->logged_email = auth('customer')->user()->email;
            $details->logged_profile_image = auth('customer')->user()->profile_image;
            $details->logged_profile_image_url = asset('customer_image/' . auth('customer')->user()->profile_image);
            $details->logged_guard = 'customer';
        } elseif (auth('web')->check()) {
            $details->logged_id = auth('web')->user()->id;
            $details->logged_name = auth('web')->user()->name;
            $details->logged_email = auth('web')->user()->email;
            $details->logged_profile_image = auth('web')->user()->profile_image;
            $details->logged_profile_image_url = asset('user_profile_image/' . auth('web')->user()->profile_image);
            $details->logged_guard = 'user';
        } elseif (auth('lawyer')->check()) {
            $details->logged_id = auth('lawyer')->user()->id;
            $details->logged_name = auth('lawyer')->user()->name;
            $details->logged_email = auth('lawyer')->user()->email;
            $details->logged_profile_image = auth('lawyer')->user()->profile_image;
            $details->logged_profile_image_url = asset('lawyer/images/' . auth('lawyer')->user()->profile_image);
            $details->logged_guard = 'lawyer';
        }

        return $details;
    }
}




if (!function_exists('saveResizedImage')) {
    function saveResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath)
    {




        $originName = $file->getClientOriginalName() . '-' . time();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '__' . time() . '.' . $extension;
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }




        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $image = Image::read($file);
            $image->resize($resizeWidth, $resizeHeight);

            $image->save($destinationPath . '/' . $fileName);

        } elseif (in_array($extension, ['pdf', 'doc', 'docx'])) {
            $file->move($destinationPath, $fileName);
        } else {
            return 'Unsupported file type';
        }

        // Return the filename or path if needed
        return $fileName;
    }
}



if (!function_exists('updateResizedImage')) {
    function updateResizedImage($file, $resizeWidth, $resizeHeight, $destinationPath, $previousImage)
    {



        $extension = strtolower($file->getClientOriginalExtension());
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }






        $originName = $file->getClientOriginalName() . '-' . time();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '__' . time() . '.' . $extension;


        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Process images

            $image = Image::read($file);

            // Resize the image
            $image->resize($resizeWidth, $resizeHeight);

            // Save the image
            $image->save($destinationPath . '/' . $fileName);



        } elseif (in_array($extension, ['pdf', 'doc', 'docx'])) {



            // Handle PDFs and DOC files
            // Just move the file without resizing since these are not image formats
            $file->move($destinationPath, $fileName);
        } else {
            // Return an error for unsupported file types
            return 'Unsupported file type';
        }









        // Delete the previous image if it exists
        if ($previousImage && file_exists($destinationPath . '/' . $previousImage)) {
            unlink($destinationPath . '/' . $previousImage);
        }

        // Return the filename of the new image
        return $fileName;
    }


}


if (!function_exists('getStepClass')) {
    function getStepClass($status)
    {
        switch ($status) {
            case '1':
                return 'text-green'; // Accepted
            case '2':
                return 'text-red'; // Rejected
            case '3':
                return 'text-yellow'; // Pending
            default:
                return 'text-gray'; // Default class for N/A
        }
    }
}


if (!function_exists('getStepStatusText')) {
    function getStepStatusText($status)
    {
        switch ($status) {
            case '1':
                return 'Accepted';
            case '2':
                return 'Rejected';
            case '3':
                return 'Pending';
            case '':
                return 'N/A';
            default:
                return '';
        }
    }
}


