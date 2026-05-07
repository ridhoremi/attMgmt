<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinoutModel extends Model
{
    protected $table = 'checkinout';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'checktime', 'machine_id'];



   public function simpanImport($data=null)
    {
        foreach ($data as $row) {

            $cek = $this->where('user_id', $row['user_id'])
                ->where('checktime', $row['checktime'])
                ->first();

            if ($cek) {
                continue;
            }

            $this->insert([
                'user_id'   => $row['user_id'],
                'checktime' => $row['checktime'],
                'machine_id'=> $row['machine'],
                'status'    => $row['status']
            ]);
        }
    }
}
