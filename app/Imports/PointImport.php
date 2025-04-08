<?php

namespace App\Imports;

use App\Models\Point;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PointImport implements ToModel, WithStartRow
{
    protected $classId;
    protected $subjectId;
    public function __construct(array $params)
    {
        $this->classId = $params['class_id'];
        $this->subjectId = $params['subject_id'];
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (! $this->isValidRow($row)) {
            return null;
        }

        $user = User::where([
            'name' => $row[1],
            'role' => 'Sinh viên',
        ])->first();

        if (!$user) {
            return null;
        }

        return new Point([
            'class_id' => $this->classId,
            'user_id' => $user->id,
            'subject_id' =>$this->subjectId,
            'point' => $row[3],
            'type' => $row[2],
        ]);
    }

    private function isValidRow(array $row): bool
    {
        return ! empty($row[1])
            && ! empty($row[2])
            && ! empty($row[3])
            && in_array($row[2], ['Kiểm tra miệng', 'Kiểm tra 15 phút', 'Kiểm tra 45 phút', 'Kiểm tra học kì']);
    }
}
