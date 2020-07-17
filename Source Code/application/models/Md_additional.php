<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_additional extends CI_Model
{
    function count($id_pelanggan)
    {
        $rows = array(); //will hold all results
        $query = $this->db->query("select * from caption_images where caption_cap = " . $id_pelanggan . "");
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $rows[] = $row["mediagr_id"];
            }
        } else {
            $query = $this->db->query("select * from caption_images where caption_cap = " . $id_pelanggan . "");
            $rows[] = $query->row_array()["mediagr_id"];
        }
        return $rows;
    }
}
