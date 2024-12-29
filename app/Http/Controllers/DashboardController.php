<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {

    public function adminDashboard() {
        $totalUsers      = User::count();
        $verifiedUsers   = User::whereNotNull( 'email_verified_at' )->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;

        $userGrowth            = $this->getUserGrowthData();
        $userRegistrationByDay = $this->getUserRegistrationByDay();
        $roles                 = $this->getUserRoles();
        $recentUsers           = $this->getRecentUsers();

        return view( 'dashboard.admin-dashboard', [
            'totalUsers'            => $totalUsers,
            'userGrowth'            => $userGrowth,
            'userRegistrationByDay' => $userRegistrationByDay,
            'roles'                 => $roles,
            'verifiedUsers'         => $verifiedUsers,
            'unverifiedUsers'       => $unverifiedUsers,
            'recentUsers'           => $recentUsers,
        ] );
    }

    public function studentDashboard() {
        $studentCount = User::where( 'Role', 'Student' )->count();

        $studentGrowth            = $this->getUserGrowthData( 'Student' );
        $studentRegistrationByDay = $this->getUserRegistrationByDay( 'Student' );
        $recentStudents           = $this->getRecentUsers( 'Student' );

        return view( 'dashboard.student-dashboard', [
            'studentCount'             => $studentCount,
            'studentGrowth'            => $studentGrowth,
            'studentRegistrationByDay' => $studentRegistrationByDay,
            'recentStudents'           => $recentStudents,
        ] );
    }

    public function guestDashboard() {
        $guestCount = User::where( 'Role', 'Guest' )->count();

        $guestGrowth            = $this->getUserGrowthData( 'Guest' );
        $guestRegistrationByDay = $this->getUserRegistrationByDay( 'Guest' );
        $recentGuests           = $this->getRecentUsers( 'Guest' );

        return view( 'dashboard.guest-dashboard', [
            'guestCount'             => $guestCount,
            'guestGrowth'            => $guestGrowth,
            'guestRegistrationByDay' => $guestRegistrationByDay,
            'recentGuests'           => $recentGuests,
        ] );
    }

    private function getUserGrowthData( string $role = null ) {
        $query = User::selectRaw( 'DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count' )
            ->groupBy( 'month' )
            ->orderBy( 'month', 'asc' );

        if ( $role ) {
            $query->where( 'Role', $role );
        }

        return $query->get();
    }

    private function getUserRegistrationByDay( string $role = null ) {
        $query = User::selectRaw( 'DATE_FORMAT(created_at, "%Y-%m-%d") as date, COUNT(*) as count' )
            ->where( 'created_at', '>=', now()->subDays( 30 ) )
            ->groupBy( 'date' )
            ->orderBy( 'date', 'asc' );

        if ( $role ) {
            $query->where( 'Role', $role );
        }

        return $query->get();
    }

    private function getRecentUsers( string $role = null ) {
        $query = User::latest( 'created_at' )->take( 5 )->get( ['name', 'email', 'created_at'] );

        if ( $role ) {
            $query->where( 'Role', $role );
        }

        return $query;
    }

    private function getUserRoles() {
        return User::select( 'Role', DB::raw( 'COUNT(*) as count' ) )
            ->groupBy( 'Role' )
            ->get();
    }

}
