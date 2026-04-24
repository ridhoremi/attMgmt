<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinoutModel extends Model
{
    protected $table = 'checkinout';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'checktime', 'machine_id'];
}
