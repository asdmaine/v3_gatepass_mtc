<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model Register
 */
class M_admin extends CI_Model
{

    public function is_login()
    {
        $is_login = $this->session->userdata('auth');
        if (!empty($is_login)) {
            return true;
        } else {
            return false;
        }
    }

    public function do_login()
    {
        $post = $this->input->post();
        if (!empty($post)) {
            $username = $post['username'];
            $password = md5($post['password']);
            $user = $this->db->query('select * from pst where pst_pnr = ?', $username)->row_array();
            $user = $this->db->query(
                "SELECT 
            a.pst_status,
            a.pst_pnr,
            a.pst_password,
            b.job_level,
            a.jobtl_idx,
            b.jobtl_name,
            a.br_idx,
            c.br_name,
            a.pst_name,
            d.verifikasi1,
            v1.pst_name as name_verif1,
            d.verifikasi2,
            v2.pst_name as name_verif2,
            d.approval1,
            d.approval2,
            d.gpverifikasi1,
            d.gpverifikasi2,
            d.gpapproval1,
            d.gpapproval2,
            v1.pst_name as verifikasi1_name,
            v2.pst_name as verifikasi2_name,
            v3.pst_name as approval1_name,
            v4.pst_name as approval2_name
            FROM 
                pst a
            left JOIN 
                hrms_jobtitle as b ON a.jobtl_idx = b.jobtl_idx
            left JOIN 
                dsaw_mdept as c ON a.br_idx = c.br_idx
            left JOIN 
                tbmleave_setting as d ON a.pst_pnr = d.pst_pnr
            left join 
                pst as v1 on v1.pst_pnr = d.verifikasi1
            left join
                pst as v2 on v2.pst_pnr = d.verifikasi2
            left join
                pst as v3 on v3.pst_pnr = d.approval1
            left join
                pst as v4 on v4.pst_pnr = d.approval2
            where a.pst_pnr = ? and a.pst_status >= 0",
                $username
            )->row_array();
            if (!empty($user)) {
                if ($user['pst_password'] == $password) {
                    // masih salah ini session expiration
                    $this->session->sess_expiration = 2000;


                    $this->session->set_userdata('auth', $user);
                    redirect('dashboard');
                    // $we = $this->session->userdata('auth');
                    // cara panggilnya $we['username'] pokoknya sesuai isi tabel karena tepat diatas dibuat untuk menjadi row_array()
                } else {
                    return 'Password tidak valid';
                }
            } else {
                return 'Username dan Password tidak valid';
            }
        }
    }

    public function GetRecommended()
    {
        $sql =
            "SELECT DISTINCT
            a.verifikasi1,
            b.pst_name
        FROM
            tbmleave_setting a
        LEFT JOIN
            pst b ON a.verifikasi1 = b.pst_pnr
        WHERE
            b.pst_status >= 0
        ORDER BY
            b.pst_name ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }
    public function GetApproved()
    {
        $sql =
            "SELECT DISTINCT
            a.approval1,
            b.pst_name
        FROM
            tbmleave_setting a
        LEFT JOIN
            pst b ON a.approval1 = b.pst_pnr
        WHERE
            b.pst_status >= 0
        ORDER BY
            b.pst_name ASC";

        $query = $this->db->query($sql);
        return $query->result();
    }
    public function SubmitGatepass($qrcode)
    {
        $post = $this->input->post(NULL, TRUE);

        if (!empty($post)) {
            $data_tbverifikasi = array(
                'verif_date_recommendedby' => null
            );
            $data_tbremarks = array(
                'remarks_recommendedby' => null
            );
            try {
                $this->db->insert('gatepass_tbverifikasi', $data_tbverifikasi);
                $id_verifikasi = $this->db->insert_id();
                $this->db->insert('gatepass_tbremarks', $data_tbremarks);
                $id_remarks = $this->db->insert_id();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            $data_tbpengesahan = array(
                'requestedby_pst_pnr' => $post['requested'],
                'recommendedby_pst_pnr' => $post['recommended'],
                'approvedby_pst_pnr' => $post['approved'],
                'acknowledgedby_pst_pnr' => $post['acknowledged'],
                'id_verifikasi' => $id_verifikasi,
                'id_remarks' => $id_remarks

            );
            try {
                $this->db->insert('gatepass_tbpengesahan', $data_tbpengesahan);
                $id_pengesahan = $this->db->insert_id();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            $data_tbtime = array(
                'est_time_out' => $post['est_time_out'],
                'est_time_in' => $post['est_time_in']
            );
            try {
                $this->db->insert('gatepass_tbtime', $data_tbtime);
                $id_time = $this->db->insert_id();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            $data_gatepass = array(
                'requestedby_pst_name' => $post['requested_name'],
                'tanggal_gatepass' => $post['tanggal'],
                'tanggal_gatepass_dibuat' => date('Y-m-d H:i:s'),
                'keperluan' => $post['keperluan'],
                'penjelasan_keperluan' => $post['penjelasan'],
                'id_time' => $id_time,
                'id_pengesahan' => $id_pengesahan,
                'qrcode' => $qrcode
            );
            try {
                $this->db->insert('gatepass_tb', $data_gatepass);
                $idd = $this->db->insert_id();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            redirect('mail/push/recommended/' . $qrcode . '/dashboard');
        } else {
            echo 'eror';
        }
    }
    public function GetProgress($pst_pnr)
    {
        $this->db->select('
    a.*,
    b.*,
    c.*,
    d.*,
    e.*,
    f.pst_name as recommended_name,
    f2.pst_name as approved_name,
    f3.pst_name as acknowledged_name'
        );
        $this->db->from('gatepass_tb a');
        $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
        $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
        $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
        $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
        $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
        $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
        $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
        $this->db->where('c.requestedby_pst_pnr', $pst_pnr);
        $this->db->where("a.status", 0);
        $this->db->order_by('a.id_gatepass', 'ASC');

        $query = $this->db->get();
        return $query->result();

    }
    public function GetProgressApproval($pst_pnr)
    {
        $this->db->select('
    a.*,
    b.*,
    c.*,
    d.*,
    e.*,
    f.pst_name as recommended_name,
    f2.pst_name as approved_name,
    f3.pst_name as acknowledged_name'
        );
        $this->db->from('gatepass_tb a');
        $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
        $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
        $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
        $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
        $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
        $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
        $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
        $this->db->where("(c.recommendedby_pst_pnr ='$pst_pnr' OR c.approvedby_pst_pnr ='$pst_pnr' OR c.acknowledgedby_pst_pnr = '$pst_pnr')");
        $this->db->where("a.status", 0);
        $this->db->order_by('a.id_gatepass', 'DESC');

        $query = $this->db->get();
        return $query->result();

    }
    public function GetLevel($pst_pnr)
    {
        try {
            $this->db->select('id');
            $this->db->from('tbmleave_setting');
            $this->db->where('verifikasi1', $pst_pnr);
            $this->db->or_where('verifikasi2', $pst_pnr);
            $this->db->or_where('approval1', $pst_pnr);
            $this->db->or_where('approval2', $pst_pnr);
            $query = $this->db->get();
            return $query->num_rows();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function isSecurity($pst_pnr)
    {
        try {
            $this->db->select('pst_idx');
            $this->db->from('pst');
            $this->db->where('pst_pnr', $pst_pnr);
            $this->db->where('br_idx', 62);
            $query = $this->db->get();
            return $query->num_rows();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function DeleteGatepass($id_gatepass)
    {
        // id_pengesahan gak perlu sih cuman supaya aman dikit aja 
        $data = array('status' => 2);
        $this->db->where('id_gatepass', $id_gatepass);
        $this->db->update('gatepass_tb', $data);
        redirect('dashboard');
    }

    public function AcceptGatepass()
    {
        $post = $this->input->post();
        try {
            // set status gatepass
            if ($post['as'] == 'acknowledged') {
                $data2 = array(
                    'status' => '1'
                );
                $this->db->where('id_gatepass', $post['id_gatepass']);
                $this->db->update('gatepass_tb', $data2);
                $data = array(
                    'status_' . $post['as'] => '1',
                    'verif_date_' . $post['as'] . 'by' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $post['id_verifikasi']);
                $this->db->update('gatepass_tbverifikasi', $data);

                $data1 = array(
                    'remarks_' . $post['as'] . 'by' => $post['remarks']
                );
                $this->db->where('id_remarks', $post['id_remarks']);
                $this->db->update('gatepass_tbremarks', $data1);
                if ($post['as'] == 'recommended') {
                    redirect('mail/push/approved/' . $post['qrcode'] . '/approve');
                } else if ($post['as'] == 'approved') {
                    redirect('mail/push/acknowledged/' . $post['qrcode'] . '/approve');
                } else if ($post['as'] == 'acknowledged') {
                    redirect('mail/push/requested/' . $post['qrcode'] . '/approve');
                }
            } else {
                $data = array(
                    'status_' . $post['as'] => '1',
                    'verif_date_' . $post['as'] . 'by' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $post['id_verifikasi']);
                $this->db->update('gatepass_tbverifikasi', $data);

                $data1 = array(
                    'remarks_' . $post['as'] . 'by' => $post['remarks']
                );
                $this->db->where('id_remarks', $post['id_remarks']);
                $this->db->update('gatepass_tbremarks', $data1);
                if ($post['as'] == 'recommended') {
                    redirect('mail/push/approved/' . $post['qrcode'] . '/approve');
                } else if ($post['as'] == 'approved') {
                    redirect('mail/push/acknowledged/' . $post['qrcode'] . '/approve');
                } else if ($post['as'] == 'acknowledged') {
                    redirect('mail/push/requested/' . $post['qrcode'] . '/approve');
                }
            }


        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }
    public function RejectGatepass()
    {
        $post = $this->input->post();
        try {

            $data2 = array(
                'status' => '-1',
            );
            $this->db->where('id_gatepass', $post['id_gatepass']);
            $this->db->update('gatepass_tb', $data2);

            $data = array(
                'status_' . $post['as'] => '-1',
                'verif_date_' . $post['as'] . 'by' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_verifikasi', $post['id_verifikasi']);
            $this->db->update('gatepass_tbverifikasi', $data);

            $data1 = array(
                'remarks_' . $post['as'] . 'by' => $post['remarks']
            );
            $this->db->where('id_remarks', $post['id_remarks']);
            $this->db->update('gatepass_tbremarks', $data1);
            redirect('approve');
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function AcceptGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass)
    {

        try {
            if ($as == 'acknowledged') {
                $data2 = array(
                    'status' => '1'
                );
                $this->db->where('id_gatepass', $id_gatepass);
                $this->db->update('gatepass_tb', $data2);
                $data = array(
                    'status_' . $as => $what,
                    'verif_date_' . $as . 'by' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $id_verifikasi);
                $this->db->update('gatepass_tbverifikasi', $data);

                // $data1 = array(
                //     'remarks_' . $as . 'by' => $post['remarks']
                // );
                // $this->db->where('id_remarks', $post['id_remarks']);
                // $this->db->update('gatepass_tbremarks', $data1);

                if ($as == 'recommended') {
                    redirect('mail/pushbyemail/approved/' . $qrcode . '/' . $what);
                } else if ($as == 'approved') {
                    redirect('mail/pushbyemail/acknowledged/' . $qrcode . '/' . $what);
                } else if ($as == 'acknowledged') {
                    redirect('mail/pushbyemail/requested/' . $qrcode . '/' . $what);
                }
            } else {
                $data = array(
                    'status_' . $as => $what,
                    'verif_date_' . $as . 'by' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $id_verifikasi);
                $this->db->update('gatepass_tbverifikasi', $data);

                // $data1 = array(
                //     'remarks_' . $as . 'by' => $post['remarks']
                // );
                // $this->db->where('id_remarks', $post['id_remarks']);
                // $this->db->update('gatepass_tbremarks', $data1);

                if ($as == 'recommended') {
                    redirect('mail/pushbyemail/approved/' . $qrcode . '/' . $what);
                } else if ($as == 'approved') {
                    redirect('mail/pushbyemail/acknowledged/' . $qrcode . '/' . $what);
                } else if ($as == 'acknowledged') {
                    redirect('mail/pushbyemail/requested/' . $qrcode . '/' . $what);
                }
            }


        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    public function RejectGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass)
    {
        $post = $this->input->post();
        try {
            $data2 = array(
                'status' => '-1'
            );
            $this->db->where('id_gatepass', $id_gatepass);
            $this->db->update('gatepass_tb', $data2);

            $data = array(
                'status_' . $as => $what,
                'verif_date_' . $as . 'by' => date('Y-m-d H:i:s')
            );
            $this->db->where('id_verifikasi', $id_verifikasi);
            $this->db->update('gatepass_tbverifikasi', $data);

            // $data1 = array(
            //     'remarks_' . $as . 'by' => $post['remarks']
            // );
            // $this->db->where('id_remarks', $post['id_remarks']);
            // $this->db->update('gatepass_tbremarks', $data1);


            redirect('mail/pushbyemail/requested/' . $qrcode . '/' . $what);


        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    public function GetHistory($pst_pnr)
    {
        $this->db->select('
    a.*,
    b.*,
    c.*,
    d.*,
    e.*,
    f.pst_name AS recommended_name,
    f2.pst_name AS approved_name,
    f3.pst_name AS acknowledged_name');
        $this->db->from('gatepass_tb a');
        $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
        $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
        $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
        $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
        $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
        $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
        $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
        $this->db->where('requestedby_pst_pnr', $pst_pnr);
        $this->db->where('a.status !=', 0);
        $this->db->where('a.status !=', 2);
        $this->db->order_by('a.tanggal_gatepass', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }


    public function GetGatepassByQrcode($pst_pnr, $qrcode)
    {
        if ($pst_pnr == 'security') {
            $this->db->select('
            a.*,
            b.*,
            c.*,
            d.*,
            e.*,
            f.pst_name AS recommended_name,
            f2.pst_name AS approved_name,
            f3.pst_name AS acknowledged_name,
            f4.signature AS requested_signature,
            f5.pst_name AS securityout_name,
            f6.pst_name AS securityin_name
                ');
            $this->db->from('gatepass_tb a');
            $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
            $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
            $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
            $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
            $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
            $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
            $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
            $this->db->join('gatepass_tbsignature f4', 'c.requestedby_pst_pnr = f4.pst_pnr', 'left');
            $this->db->join('pst f5', 'c.securityout_pst_pnr = f5.pst_pnr', 'left');
            $this->db->join('pst f6', 'c.securityin_pst_pnr = f6.pst_pnr', 'left');
            $this->db->where('qrcode', $qrcode);
            $this->db->where('a.status !=', 0);
            $this->db->where('a.status !=', 2);
            $this->db->order_by('a.tanggal_gatepass', 'DESC');

            $query = $this->db->get();
            return $query->result();
        } else {
            $this->db->select('
            a.*,
            b.*,
            c.*,
            d.*,
            e.*,
            f.pst_name AS recommended_name,
            f2.pst_name AS approved_name,
            f3.pst_name AS acknowledged_name,
            f4.signature AS requested_signature,
            f5.pst_name AS securityout_name,
            f6.pst_name AS securityin_name');
            $this->db->from('gatepass_tb a');
            $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
            $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
            $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
            $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
            $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
            $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
            $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
            $this->db->join('gatepass_tbsignature f4', 'c.requestedby_pst_pnr = f4.pst_pnr', 'left');
            $this->db->join('pst f5', 'c.securityout_pst_pnr = f5.pst_pnr', 'left');
            $this->db->join('pst f6', 'c.securityin_pst_pnr = f6.pst_pnr', 'left');
            $this->db->where('requestedby_pst_pnr', $pst_pnr);
            $this->db->where('qrcode', $qrcode);
            $this->db->where('a.status !=', 0);
            $this->db->where('a.status !=', 2);
            $this->db->order_by('a.tanggal_gatepass', 'DESC');

            $query = $this->db->get();
            return $query->result();
        }

    }
    public function GetGatepassForMail($qrcode)
    {

        $this->db->select('
            a.*,
            b.*,
            c.*,
            d.*,
            e.*,
            f.pst_name AS recommended_name,
            f.email AS recommended_mail,
            f2.pst_name AS approved_name,
            f2.email AS approved_mail,
            f3.pst_name AS acknowledged_name,
            f3.email AS acknowledged_mail,
            f4.signature AS requested_signature,
            f5.pst_name AS securityout_name,
            f6.pst_name AS securityin_name,
            f7.pst_name AS requested_name
                ');
        $this->db->from('gatepass_tb a');
        $this->db->join('gatepass_tbtime b', 'a.id_time = b.id_time', 'left');
        $this->db->join('gatepass_tbpengesahan c', 'a.id_pengesahan = c.id_pengesahan', 'left');
        $this->db->join('gatepass_tbverifikasi d', 'c.id_verifikasi = d.id_verifikasi', 'left');
        $this->db->join('gatepass_tbremarks e', 'c.id_remarks = e.id_remarks', 'left');
        $this->db->join('pst f', 'c.recommendedby_pst_pnr = f.pst_pnr', 'left');
        $this->db->join('pst f2', 'c.approvedby_pst_pnr = f2.pst_pnr', 'left');
        $this->db->join('pst f3', 'c.acknowledgedby_pst_pnr = f3.pst_pnr', 'left');
        $this->db->join('gatepass_tbsignature f4', 'c.requestedby_pst_pnr = f4.pst_pnr', 'left');
        $this->db->join('pst f5', 'c.securityout_pst_pnr = f5.pst_pnr', 'left');
        $this->db->join('pst f6', 'c.securityin_pst_pnr = f6.pst_pnr', 'left');
        $this->db->join('pst f7', 'c.requestedby_pst_pnr = f7.pst_pnr', 'left');
        $this->db->where('qrcode', $qrcode);
        $this->db->order_by('a.tanggal_gatepass', 'DESC');
        $query = $this->db->get();
        // $result = $query->result_array();
        // print_r($result);
        // echo $result[0]['id_gatepass'];
        return $query->result();

    }
    public function GetSignature($pst_pnr)
    {
        $this->db->select('signature');
        $this->db->from('gatepass_tbsignature');
        $this->db->where('pst_pnr', $pst_pnr);

        $query = $this->db->get();

        $result = $query->row();

        // Jika ada hasil, kembalikan signature sebagai string tunggal, jika tidak, kembalikan null
        return ($result) ? $result->signature : null;

    }
    public function SetRealTimeOut($pst_pnr)
    {
        $post = $this->input->post();
        if (empty($post)) {
            redirect('dashboard?alert=ditolak');
        } else {
            try {
                $data = array(
                    'securityout_pst_pnr' => $pst_pnr
                );
                $this->db->where('id_pengesahan', $post['id_pengesahan']);
                $this->db->update('gatepass_tbpengesahan', $data);

                $data1 = array(
                    'real_time_out' => date('H:i:s')
                );
                $this->db->where('id_time', $post['id_time']);
                $this->db->update('gatepass_tbtime', $data1);

                $data2 = array(
                    'verif_date_securityout' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $post['id_verifikasi']);
                $this->db->update('gatepass_tbverifikasi', $data2);

                $data3 = array(
                    'remarks_securityout' => $post['remarks']
                );
                $this->db->where('id_remarks', $post['id_remarks']);
                $this->db->update('gatepass_tbremarks', $data3);
                redirect('scan?alert=strltin1');
            } catch (Exception $e) {
                redirect('scan?alert=strltin0');
                echo "Error: " . $e->getMessage();
            }
        }
    }
    public function SetRealTimeIn($pst_pnr)
    {
        $post = $this->input->post();
        if (empty($post)) {
            redirect('dashboard?alert=ditolak');
        } else {
            try {
                $data = array(
                    'securityin_pst_pnr' => $pst_pnr
                );
                $this->db->where('id_pengesahan', $post['id_pengesahan']);
                $this->db->update('gatepass_tbpengesahan', $data);

                $data1 = array(
                    'real_time_in' => date('H:i:s')
                );
                $this->db->where('id_time', $post['id_time']);
                $this->db->update('gatepass_tbtime', $data1);

                $data2 = array(
                    'verif_date_securityin' => date('Y-m-d H:i:s')
                );
                $this->db->where('id_verifikasi', $post['id_verifikasi']);
                $this->db->update('gatepass_tbverifikasi', $data2);

                $data3 = array(
                    'remarks_securityin' => $post['remarks']
                );
                $this->db->where('id_remarks', $post['id_remarks']);
                $this->db->update('gatepass_tbremarks', $data3);
                redirect('scan?alert=strltin1');
            } catch (Exception $e) {
                redirect('scan?alert=strltin0');
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function cekSignature($pst_pnr)
    {
        try {
            $this->db->select('id_signature');
            $this->db->from('gatepass_tbsignature');
            $this->db->where('pst_pnr', $pst_pnr);
            $query = $this->db->get();
            return $query->num_rows();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function ThisMonth($pst_pnr)
    {
        $date = date('Y-m');
        $query = $this->db->query(
            "
        SELECT id_gatepass
        FROM `gatepass_tb` `a` 
        JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
        WHERE DATE_FORMAT(a.tanggal_gatepass, '%Y-%m') = '$date'
        AND `requestedby_pst_pnr` = '$pst_pnr' AND `status` = 1;"
        )->num_rows();
        return $query;

    }
    public function LastMonth($pst_pnr)
    {
        $date = date('Y-m', strtotime('-1 month'));
        $query = $this->db->query(
            "
        SELECT id_gatepass
        FROM `gatepass_tb` `a` 
        JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
        WHERE DATE_FORMAT(a.tanggal_gatepass, '%Y-%m') = '$date'
        AND `requestedby_pst_pnr` = '$pst_pnr' AND `status` = 1;"
        )->num_rows();
        return $query;
    }
    public function ThisYear($pst_pnr)
    {

        $year = date('Y');

        $query = $this->db->query(
            "
            SELECT id_gatepass
            FROM `gatepass_tb` `a` 
            JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
            WHERE YEAR(a.tanggal_gatepass) = '$year'
            AND `requestedby_pst_pnr` = '$pst_pnr' AND `status` = 1"
        )->num_rows();

        return $query;

    }
    public function AllThisMonth()
    {
        $date = date('Y-m');
        $query = $this->db->query(
            "
        SELECT id_gatepass
        FROM `gatepass_tb` `a` 
        JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
        WHERE DATE_FORMAT(a.tanggal_gatepass, '%Y-%m') = '$date'
        AND `status` = 1;"
        )->num_rows();
        return $query;

    }
    public function AllLastMonth()
    {
        $date = date('Y-m', strtotime('-1 month'));
        $query = $this->db->query(
            "
        SELECT id_gatepass
        FROM `gatepass_tb` `a` 
        JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
        WHERE DATE_FORMAT(a.tanggal_gatepass, '%Y-%m') = '$date'
        AND `status` = 1;"
        )->num_rows();
        return $query;
    }
    public function AllThisYear()
    {

        $year = date('Y');

        $query = $this->db->query(
            "
            SELECT id_gatepass
            FROM `gatepass_tb` `a` 
            JOIN `gatepass_tbpengesahan` AS `b` ON `a`.`id_pengesahan` = `b`.`id_pengesahan` 
            WHERE YEAR(a.tanggal_gatepass) = '$year'
            AND `status` = 1"
        )->num_rows();

        return $query;

    }
    public function GetHistoryYear($year)
    {
        $query = $this->db->query(
            "
            SELECT 
    a.*, b.*, c.*, d.*, e.*, 
    f.pst_name AS recommended_name, 
    f2.pst_name AS approved_name, 
    f3.pst_name AS acknowledged_name, 
    f4.signature AS requested_signature, 
    f5.pst_name AS securityout_name, 
    f6.pst_name AS securityin_name 
        FROM 
            gatepass_tb a
        LEFT JOIN 
            gatepass_tbtime b ON a.id_time = b.id_time
        LEFT JOIN 
            gatepass_tbpengesahan c ON a.id_pengesahan = c.id_pengesahan
        LEFT JOIN 
            gatepass_tbverifikasi d ON c.id_verifikasi = d.id_verifikasi
        LEFT JOIN 
            gatepass_tbremarks e ON c.id_remarks = e.id_remarks
        LEFT JOIN 
            pst f ON c.recommendedby_pst_pnr = f.pst_pnr
        LEFT JOIN 
            pst f2 ON c.approvedby_pst_pnr = f2.pst_pnr
        LEFT JOIN 
            pst f3 ON c.acknowledgedby_pst_pnr = f3.pst_pnr
        LEFT JOIN 
            gatepass_tbsignature f4 ON c.requestedby_pst_pnr = f4.pst_pnr
        LEFT JOIN 
            pst f5 ON c.securityout_pst_pnr = f5.pst_pnr
        LEFT JOIN 
            pst f6 ON c.securityin_pst_pnr = f6.pst_pnr
        WHERE 
            YEAR(a.tanggal_gatepass) = '$year'
        AND 
            a.status != 0
            and a.status != 2
        ORDER BY 
            a.tanggal_gatepass DESC"
        );
        return $query->result();

    }
    public function GetHistoryToday($pst_pnr)
    {
        $date = date('Y-m-d');
        $query = $this->db->query(
            "
            SELECT 
            a.*, 
            b.*, 
            c.*, 
            d.*, 
            e.*, 
            f.pst_name AS recommended_name, 
            f2.pst_name AS approved_name, 
            f3.pst_name AS acknowledged_name
        FROM 
            gatepass_tb a
        LEFT JOIN 
            gatepass_tbtime b ON a.id_time = b.id_time
        LEFT JOIN 
            gatepass_tbpengesahan c ON a.id_pengesahan = c.id_pengesahan
        LEFT JOIN 
            gatepass_tbverifikasi d ON c.id_verifikasi = d.id_verifikasi
        LEFT JOIN 
            gatepass_tbremarks e ON c.id_remarks = e.id_remarks
        LEFT JOIN 
            pst f ON c.recommendedby_pst_pnr = f.pst_pnr
        LEFT JOIN 
            pst f2 ON c.approvedby_pst_pnr = f2.pst_pnr
        LEFT JOIN 
            pst f3 ON c.acknowledgedby_pst_pnr = f3.pst_pnr
        WHERE 
            requestedby_pst_pnr = '$pst_pnr'
        AND 
            a.status != 0
            and a.status != 2
        AND 
        DATE_FORMAT(a.tanggal_gatepass_dibuat, '%Y-%m-%d') = '$date'
        ORDER BY 
            a.tanggal_gatepass_dibuat DESC;
        "
        );
        return $query->result();
    }
    public function NumHistoryToday($pst_pnr, $tanggal_gatepass)
    {

        $query = $this->db->query(
            "
            SELECT 
            a.*
        FROM 
            gatepass_tb a
        LEFT JOIN 
            gatepass_tbtime b ON a.id_time = b.id_time
        LEFT JOIN 
            gatepass_tbpengesahan c ON a.id_pengesahan = c.id_pengesahan
        WHERE 
            requestedby_pst_pnr = '$pst_pnr'
        AND 
            a.status != 2
        AND 
        DATE_FORMAT(a.tanggal_gatepass, '%Y-%m-%d') = '$tanggal_gatepass'
        "
        );
        return $query->num_rows();
    }
    public function getpstpnrfromgatepass($id_gatepass)
    {
        $query = $this->db->query(
            "
            SELECT a.id_pengesahan,b.*
            FROM gatepass_tb a
            LEFT JOIN gatepass_tbpengesahan b ON a.id_pengesahan = b.id_pengesahan
            WHERE a.id_gatepass = '$id_gatepass';
            "
        );
        return $query->result();
    }
    public function cekrecommended($id_verifikasi, $id_gatepass)
    {
        // cek status gatepass
        $cekgatepass = $this->db->query(
            "
            select 
                *
            from
                gatepass_tb
            where
                id_gatepass = '$id_gatepass';
            "
        );
        $gp_status = $cekgatepass->result();

        // cek status verifikasi
        if ($gp_status[0]->status == '0') {
            $query = $this->db->query(
                "
            select 
                *
            from
                gatepass_tbverifikasi
            where
                id_verifikasi = '$id_verifikasi';
            "
            );
            $status = $query->result();
            return $status[0]->status_recommended;
        } else {
            echo '<script>alert("Permintaan gatepass telah berakhir"); window.close();</script>';
        }
    }
    public function cekapproved($id_verifikasi, $id_gatepass)
    {
        // cek status gatepass
        $cekgatepass = $this->db->query(
            "
            select 
                *
            from
                gatepass_tb
            where
                id_gatepass = '$id_gatepass';
            "
        );
        $gp_status = $cekgatepass->result();

        // cek status verifikasi
        if ($gp_status[0]->status == '0') {
            $query = $this->db->query(
                "
            select 
                *
            from
                gatepass_tbverifikasi
            where
                id_verifikasi = '$id_verifikasi';
            "
            );
            $status = $query->result();
            return $status[0]->status_approved;
        } else {
            echo '<script>alert("Permintaan gatepass telah berakhir"); window.close();</script>';
        }
    }
    public function cekacknowledged($id_verifikasi, $id_gatepass)
    {
        // cek status gatepass
        $cekgatepass = $this->db->query(
            "
            select 
                *
            from
                gatepass_tb
            where
                id_gatepass = '$id_gatepass';
            "
        );
        $gp_status = $cekgatepass->result();

        // cek status verifikasi
        if ($gp_status[0]->status == '0') {
            $query = $this->db->query(
                "
            select 
                *
            from
                gatepass_tbverifikasi
            where
                id_verifikasi = '$id_verifikasi';
            "
            );
            $status = $query->result();
            return $status[0]->status_acknowledged;
        } else {
            echo '<script>alert("Permintaan gatepass telah berakhir"); window.close();</script>';
        }
    }

}

?>