<?php

namespace App\Providers;

use App\Models\SidebarMenu;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $adminMenu = [];
        $userMenu = [];

        $json = json_decode(file_get_contents(resource_path('data/sidebar.json')), true);
        $exts = getExtsID();
        for ($i = 0; $i < count($json['admin']); $i++) {
            if (isset($json['admin'][$i]['addon'])) {
                $json['admin'][$i]['status'] = $exts[$json['admin'][$i]['addon']];
            }
        }
        for ($i = 0; $i < count($json['user']); $i++) {
            if (isset($json['user'][$i]['addon'])) {
                $json['user'][$i]['status'] = $exts[$json['user'][$i]['addon']];
            }
        }

        $newJsonString = json_encode($json, JSON_PRETTY_PRINT);
        file_put_contents(resource_path('data/sidebar.json'), stripslashes($newJsonString));

        $adminMenu = arrayToObject($json['admin']);
        $user = $json['user'];
        if (getExt('5')->status == 1) {
            $data = file_get_contents(resource_path('data/page_builder.json'));
            $page = json_decode($data, true);
            $userMenu = arrayToObject(array_merge($user, $page));
        } else {
            $userMenu = arrayToObject($json['user']);
        }

        \View::share('menuData', [$adminMenu]);
        \View::share('usermenuData', [$userMenu]);
    }
}