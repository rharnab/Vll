<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

        


        view()->composer('*', function($view) {
            if (Auth::check()) {
                $role_id= Auth::user()->role_id;
                $parent_menus = DB::table("menus_list")->where([
                    ['level', "=", 1],
                    ['role', 'like', '%'.$role_id.'%']
                ])->orderBy('postition', 'asc')->get();
        
                
                $child_menus = DB::table("menus_list")->where([
                    ['level', "=", 2],
                    ['role', 'like', '%'.$role_id.'%']
                ])->orderBy('postition', 'asc')->get();
                $sub_menus = DB::table("menus_list")->where([
                    ['level', "=", 3],
                    ['role', 'like', '%'.$role_id.'%']
                ])->orderBy('postition', 'asc')->get();
                $sub_child_menus = DB::table("menus_list")->where([
                    ['level', "=", 4],
                    ['role', 'like', '%'.$role_id.'%']
                ])->orderBy('postition', 'asc')->get();
        
                view()->share('parent_menus', $parent_menus);
                view()->share('child_menus', $child_menus);
                view()->share('sub_menus', $sub_menus);
                view()->share('sub_child_menus', $sub_child_menus);
            }
        });


        
        

        
    }
}
