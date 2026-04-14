<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserStaffsExport implements FromCollection, withHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('role', 'staff')->get()->map(function($user, $index) {
            $defaultPassword = substr($user->email, 0, 4) . $user->id;

            if(Hash::check($defaultPassword, $user->password)) {
                $passwordToShow = $defaultPassword;
            } else {
                $passwordToShow = 'This Account Has Been Updated';
            }

            return [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $passwordToShow,
             ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
        ];
    }
}
