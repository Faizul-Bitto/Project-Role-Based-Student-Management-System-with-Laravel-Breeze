<?php

namespace App\Http\Controllers;

use App\Models\User;

class GuestController extends Controller {
    public function index() {
        $users = User::where( 'Role', '!=', 'Admin' )
            ->paginate( 2 );

        return view( 'pages.guest.index', compact( 'users' ) );
    }
}
