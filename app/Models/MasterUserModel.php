<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class MasterUserModel extends Model
{
    protected $DBGroup = 'kepeg';
    protected $table = 'users';
    // protected $allowedFields = ['username', 'password'];


    public function getUser($username)
    {
        return $this
            ->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();
    }

    public function getUserByUserId($user_id)
    {
        return $this
            ->table('users.*,pegawai.*')
            ->where('users.id', $user_id)
            ->join('pegawai', 'pegawai.user_id = users.id')
            ->get()
            ->getRowArray();
    }
}
