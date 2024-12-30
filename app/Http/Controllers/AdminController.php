<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdminStoreUserRequest;
use App\Http\Requests\AdminUpdateUserRequest;

class AdminController extends Controller {

    public function index() {
        $users = User::paginate( 5 );

        return view( 'pages.admin.index', compact( 'users' ) );
    }

    public function create() {
        return view( 'pages.admin.create' );
    }

    public function store( AdminStoreUserRequest $request ) {
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
            'student_id' => $validated['role'] === 'Student' ? $validated['student_id'] : null,
            'role'       => $validated['role'],
        ] );

        $role = Role::where( 'name', $validated['role'] )->first();

        if ( $role ) {
            $user->assignRole( $role );
        }

        return redirect()->route( 'admin.users' )->with( 'success', 'User created successfully.' );
    }

    public function edit( User $user ) {

        if ( $user->hasRole( 'Admin' ) ) {
            return response()->json( [
                'error' => 'Admin User Cannot be Edited',
            ], 400 ); // 400 Bad Request for error
        }

        return view( 'pages.admin.edit', compact( 'user' ) );
    }

    public function update( AdminUpdateUserRequest $request, User $user ) {

        $validated = $request->validated();

        $imagePath = $user->image;

        if ( $photo = $request->file( 'image' ) ) {

            if ( $user->image && file_exists( public_path( $user->image ) ) ) {
                unlink( public_path( $user->image ) );
            }

            $photo->move( public_path( 'uploads' ), $photo->getClientOriginalName() );

            $imagePath = 'uploads/' . $photo->getClientOriginalName();
        }

        $user->update( [
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'image'      => $imagePath,
            'student_id' => $validated['role'] === 'Student' ? $validated['student_id'] : null,
        ] );

        if ( !empty( $validated['password'] ) ) {
            $user->password = Hash::make( $validated['password'] );
            $user->save();
        }

        if ( $user->roles->first()->name !== $validated['role'] ) {
            $user->syncRoles( [$validated['role']] );
        }

        return redirect()
            ->route( 'admin.users' )
            ->with( 'success', 'User updated successfully.' );
    }

    public function destroy( User $user ) {

        if ( $user->hasRole( 'Admin' ) ) {
            return response()->json( [
                'error' => 'Admin User Cannot be Deleted',
            ], 400 ); // 400 Bad Request for error
        }

        if ( $user->image ) {
            Storage::delete( "public/{$user->image}" );
        }

        $user->delete();

        return redirect()
            ->route( 'admin.users' )
            ->with( 'success', 'User deleted successfully.' );
    }

}
