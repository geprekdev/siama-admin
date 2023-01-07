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
    public function __construct(private string $date)
    {
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row): Model|null
    {
        $classroom = DB::table('classrooms_classroom')->where('grade', $row[2])->first();
        $teacher = DB::table('auth_user')->where('first_name', 'LIKE', "%{$row[3]}%")->first();
        $subject = DB::table('classrooms_classroomsubject')
            ->select('id')
            ->where('name', $row[4])
            ->where('classroom_id', $classroom->id)
            ->where('teacher_id', $teacher->id)
            ->first();

        if (is_null($subject)) {
            throw new Exception("Mapel {$row[4]} dengan guru {$teacher->first_name} dan kelas {$classroom->grade} tidak ditemukan");
        }

        return new Timetable([
            'token' => Str::upper(Str::random(4)),
            'date' => $this->date,
            'start_time' => $row[0],
            'end_time' => $row[1],
            'subject_id' => $subject->id,
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'date_format:H:i'],
            '1' => ['required', 'date_format:H:i'],
            '2' => function ($attribute, $value, $onFailure) {
                $classroom = DB::table('classrooms_classroom')->select('id')->where('grade', $value)->first();

                if (is_null($classroom)) {
                    $onFailure("kelas {$value}");
                }
            },
            '3' => function ($attribute, $value, $onFailure) {
                $teacher = DB::table('auth_user')->select('id')->where('first_name', 'LIKE', "%{$value}%")->first();

                if (is_null($teacher)) {
                    $onFailure("nama {$value}");
                }
            },
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
