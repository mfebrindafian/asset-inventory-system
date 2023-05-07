<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterAksesUserLevelModel extends Model
{
    protected $table = 'tbl_akses_user_level';
    protected $allowedFields = ['user_id', 'level_id', 'satker_id'];

    public function getAllAkses()
    {
        return $this
            ->table($this->table)
            ->get()
            ->getResultArray();
    }

    public function getAllAksesByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->select('level_id,satker_id')
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }
    public function getAllIdByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }

    // public function getAllAkses()
    // {
    //     $query = ('SELECT * FROM dbsibamira.tbl_akses_user_level tn join kepeg.referensi_unit_kerja tn1 where tn.satker_id = tn1.id_ref_unit_kerja');
    //     return $this->db->query($query)->getResultArray();
    // }

    public function getUserLevel($user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.nama_level')
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->join('user_level', 'tbl_akses_user_level.level_id = user_level.id')
            ->get()
            ->getResultArray();
    }

    public function getSatkerId($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('level_id', 3)
            ->get()
            ->getRowArray();
    }





    public function getAksesMenu($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAksesMenuLevel($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getAksesSubmenu($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }

    public function getAksesSubmenuLevel($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }
}
