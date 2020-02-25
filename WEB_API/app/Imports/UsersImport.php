<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class UsersImport implements ToCollection
class UsersImport implements ToModel,WithHeadingRow
// class UsersImport implements ToArray
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
        ]);

    }
    // public function collection(Collection $rows)
    // {
    //     //如果需要去除表头
    //     unset($rows[0]);
    //     //$rows 是数组格式
    //     $this->createData($rows);
    // }
    // public function createData($rows)
    // {
    //     dd($rows);
    // }

    // public function array(array $tables)
    // {
    //     return $tables;
    // }

}
