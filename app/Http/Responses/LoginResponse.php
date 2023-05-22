<?php

namespace App\Http\Responses;

use App\Models\UserLogin;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        if (auth()->user()->role_id != 2) {
            return redirect()->intended(config('fortify.admin'));
        } else {
            try {
                $info = json_decode(json_encode(getIpInfo()), true);
                $ip =  @implode(',', $info['ip']);
                $exist = UserLogin::where('user_ip', $ip)->first();
                $userLogin = new UserLogin();
                if ($exist) {
                    $userLogin->longitude =  $exist->longitude;
                    $userLogin->latitude =  $exist->latitude;
                    $userLogin->location =  $exist->location;
                    $userLogin->country_code = $exist->country_code;
                    $userLogin->country =  $exist->country;
                } else {
                    $userLogin->longitude =  @implode(',', $info['long']);
                    $userLogin->latitude =  @implode(',', $info['lat']);
                    $userLogin->location =  @implode(',', $info['city']) . (" - " . @implode(',', $info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ");
                    $userLogin->country_code = @implode(',', $info['code']);
                    $userLogin->country =  @implode(',', $info['country']);
                }

                $userAgent = osBrowser();
                $userLogin->user_id = auth()->user()->id;
                $userLogin->user_ip =  $ip;

                $userLogin->browser = @$userAgent['browser'];
                $userLogin->os = @$userAgent['os_platform'];
                $userLogin->save();
            } catch (\Throwable $th) {
                //throw $th;
            }
            return redirect()->intended(config('fortify.home'));
        }
    }
}