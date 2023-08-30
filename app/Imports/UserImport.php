<?php

namespace App\Imports;

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts
{
    private string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $password = $this->role === 'student'
                ? $row['username']
                : 'snapan';

            $user = User::query()->create([
                'first_name' => $row['nama'],
                'username' => $row['username'],
                'password' => django_password_hash($password),
                'is_superuser' => false,
                'is_staff' => false,
                'is_active' => true,
                'last_name' => '',
                'email' => '',
                'date_joined' => now(),
            ]);

            $group = Group::query()->where('name', $this->role)->first();

            $user->groups()->attach($group->id);

            if ($this->role === 'student') {
                $classroom = DB::table('classrooms_classroom')->where('grade', $row['kelas'])->first();

                DB::table('classrooms_classroom_student')
                    ->insert(['classroom_id' => $classroom->id, 'user_id' => $user->id]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique(User::class, 'username')],
            'kelas' => [Rule::exists('classrooms_classroom', 'grade')],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
