<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    //
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest())
        return Redirect::guest('login');
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
/*
Route::filter('Quan-Ly-Tin-Tuc', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Tin-Tuc';
    $arrAdminRoles = Session::get('adminRoles');
    //var_dump($arrAdminRoles);
    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào tin tức .'));
    } else {
        //  return $check;
    }
});

Route::filter('Quan-Ly-Admin', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Admin';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý Admin .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-San-Pham', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-San-Pham';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý sản phẩm .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Don-Hang', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Don-Hang';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý đơn hàng .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Kho', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Kho';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý kho .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Ho-Tro-Vien', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Ho-Tro-Vien';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý hỗ trợ viên .'));
    } else {
        //    return $check;
    }
});

Route::filter('Quan-Ly-Khach-Hang', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Khach-Hang';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý khách hàng .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Cac-Trang', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Cac-Trang';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý trang .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Cau-Hinh', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Cau-Hinh';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào cấu hình .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Menu', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Menu';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý menu .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Du-An', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Du-An';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý dự án .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Lich-Su', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Lich-Su';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý lịch sử .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Phan-Hoi', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Phan-Hoi';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý phản hồi .'));
    } else {
        //    return $check;
    }
});
Route::filter('Quan-Ly-Thong-Ke', function() {
//Code check
    $check = false;
    $roleaccess = 'Quan-Ly-Thong-Ke';
    $arrAdminRoles = Session::get('adminRoles');

    foreach ($arrAdminRoles[0] as $role) {
        if ($role->rolesCode == $roleaccess) {
            $check = true;
        }
    }
    if ($check == false) {
        return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Bạn không có quyền truy cập vào quản lý thống kê.'));
    } else {
        //    return $check;
    }
});*/
Route::filter('kiemtradangnhap', function() {
    if (!Session::has('adminSession')) {
        Session::forget('urlBack');
        Session::push('urlBack', URL::current());
        return Redirect::action('LoginController@getDangNhap');
    }
});
