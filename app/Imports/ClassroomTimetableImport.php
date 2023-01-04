<?php

namespace App\Imports;

use App\Models\Classrooms\Timetable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ClassroomTimetableImport implements ToModel, WithStartRow, WithValidation, WithBatchInserts
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row): Model|null
    {
        $classroom = DB::table('classrooms_classroom')->select('id')->where('grade', $row[3])->first();
        $teacher = DB::table('auth_user')->select('id')->where('username', $row[4])->first();
        $subject = DB::table('classrooms_classroomsubject')
            ->select('id')
            ->where('name', $row[5])
            ->where('classroom_id', $classroom->id)
            ->where('teacher_id', $teacher->id)
            ->first();

        if (is_null($subject)) {
            throw new Exception("Mapel {$row[5]} tidak ditemukan");
        }

        return new Timetable([
            'token' => Str::upper(Str::random(4)),
            'date' => $row[0],
            'start_time' => $row[1],
            'end_time' => $row[2],
            'subject_id' => $subject->id,
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'date'],
            '1' => ['required', 'date_format:H:i'],
            '2' => ['required', 'date_format:H:i'],
            '3' => function ($attribute, $value, $onFailure) {
                $classroom = DB::table('classrooms_classroom')->select('id')->where('grade', $value)->first();

                if (is_null($classroom)) {
                    $onFailure("kelas {$value}");
                }
            },
            '4' => function ($attribute, $value, $onFailure) {
                $teacher = DB::table('auth_user')->select('id')->where('username', $value)->first();

                if (is_null($teacher)) {
                    $onFailure("username {$value}");
                }
            },
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
