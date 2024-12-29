<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller {
    /**
     * Display the registration view.
     */
    public function create(): View {
        // Fetch all roles except Admin for the registration dropdown
        $roles = Role::whereNotIn( 'name', ['Admin'] )->pluck( 'name' );
        return view( 'auth.register', compact( 'roles' ) );
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store( Request $request ): RedirectResponse {
        // Validate inputs based on the selected role
        $request->validate( [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'role'       => ['required', 'string'],
            'phone'      => ['required', 'string', 'unique:users'],
            'image'      => ['nullable', 'image', 'max:2048'],
            'student_id' => ['required_if:role,Student', 'nullable', 'string', 'unique:users,student_id'],
        ] );

// Handle image upload
        $imagePath = '';
        $photo     = $request->file( 'image' );

        if ( $photo ) {
            $photo->move( public_path( 'uploads' ), $photo->getClientOriginalName() );
            $imagePath = 'uploads/' . $photo->getClientOriginalName();
        }

// Create the user with role-specific data
        $user = User::create( [
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make( $request->password ),
            'image'      => $imagePath,
            'role'       => $request->role,
            'student_id' => $request->role === 'Student' ? $request->student_id : null,
        ] );

// Assign the role to the user
        $role = Role::where( 'name', $request->role )->first();

        if ( $role ) {
            $user->assignRole( $role );
        }

        event( new Registered( $user ) );

        Auth::login( $user );

        return redirect( route( 'dashboard', absolute: false ) );
    }

}
