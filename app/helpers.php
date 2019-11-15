<?php

/**
 * Global helpers file with misc functions.
 */

use Hashids\Hashids;

if (!function_exists('db')) {

    /**
     * @param $table
     * @return \Illuminate\Database\Query\Builder
     */
    function db($table)
    {
        return \Illuminate\Support\Facades\DB::table($table);
    }
}

if (!function_exists('storage')) {

    /**
     * @param $disk
     * @return \Illuminate\Contracts\Filesystem\Filesystem|\Illuminate\Filesystem\FilesystemAdapter
     */
    function storage($disk = null)
    {
        return \Illuminate\Support\Facades\Storage::disk($disk);
    }
}

if (!function_exists('checkPermission')) {
    /**
     * @param $table
     * @param $id
     * @param $field
     * @throws Exception
     */
    function checkPermission($table, $id, $field)
    {
        $obj = \Illuminate\Support\Facades\DB::table($table)->find($id);
        if (!$obj) {
            throw new \Exception('非法参数！');
        }
        //不是总管理员
        if (!getUser()->hasRole('superAdmin')) {
            if ($obj->$field != getUserId()) {
                throw new \Exception('没有权限！');
            }
        }
    }
}


if (!function_exists('json')) {
    /**
     * @param int $code 状态码
     * @param string $message 状态描述
     * @param null $data 返回数据
     * @param int $statusCode
     * @param boolean $numberCheck
     * @return \Illuminate\Http\JsonResponse
     */
    function json(int $code, string $message, $data = null, $statusCode = 200, $numberCheck = false)
    {
        $array = [
            'code' => $code,
            'message' => $message,
        ];

        if ($data != null) {
            $array['data'] = $data;
        }
        if(!$numberCheck){
            return response()->json($array, $statusCode);
        }

        return response()->json($array, $statusCode,[],JSON_NUMERIC_CHECK);
    }
}

if (!function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it  = new recursiveIteratorIterator($rdi);
            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }
                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('getUserId')) {

    /**
     * @return int|mixed
     */
    function getUserId()
    {
        return auth()->id();
    }
}
if (!function_exists('getAdminUser')) {

    /**
     * @return int|mixed
     */
    function getAdminUser()
    {
        return auth('admin')->user();
    }
}
if (!function_exists('getToken')) {

    /**
     * @return int|mixed
     */
    function getToken()
    {
        return request('token');
    }
}

if (!function_exists('checkSms')) {

    /**
     * 验证短信是否过期
     * @param $phone
     * @param $code
     * @return bool
     */
    function checkSms($phone, $code)
    {
        $model = \App\Models\System\Sms::where([
            'code' => $code,
            'phone' => $phone,
            ['created_at', '>=', now()->addSecond(-env('VERIFY_CODE_EXPIRED_TIME',60))->toDateTimeString()],
        ])->first();

        if (!$model) {
            return false;
        }

        return true;
    }
}

if (!function_exists('setting')) {
    /**
     * 获取设置信息.
     * @param $userID
     * @return mixed
     */
    function setting($userID)
    {
        $setting = (new \App\Models\System\Setting())->where('user_id', $userID)->first();

        return $setting;
    }
}


if (!function_exists('hash')){
    /**
     * 哈希
     * @return Hashids
     */
    function hash(){
        $hash = new Hashids(config('hashids.SALT'), config('hashids.LENGTH'), config('hashids.ALPHABET'));
        return $hash;
    }

}







