<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StudentStoreGuestUserRequest;

class StudentController extends Controller {
    public function index() {
        $users = User::where( 'Role', '!=', 'Admin' )->paginate( 5 );

        return view( 'pages.student.index', compact( 'users' ) );
    }

    public function create() {
        return view( 'pages.student.create' );
    }

    public function store( StudentStoreGuestUserRequest $request ) {
        $validated = $request->validated();

        $imagePath = '';

        if ( $photo = $request->file( 'image' ) ) {
            $photo->move( public_path( 'uploads' ), $photo->getClientOriginalName() );

            $imagePath = 'uploads/' . $photo->getClientOriginalName();
        }

        $user = User::create( [
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => Hash::make( $validated['password'] ),
            'phone'      => $validated['phone'],
            'image'      => $imagePath,
            'role'       => 'Guest',
            'student_id' => $validated['role'] === 'Student' ? $validated['student_id'] : null,
        ] );

        $user->assignRole( 'guest' );

        return redirect()
            ->route( 'student.dashboard' )
            ->with( 'success', 'Guest user created successfully.' );
    }

}
