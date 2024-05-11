<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Model Register
 */
class M_signature extends CI_Model
{
    public function SetSignature()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=dbgatepass', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $new_signature = $_POST['signature'];
            $pst_pnr = $_POST['pst_pnr'];

            $query1 = "select id_signature from gatepass_tbsignature where pst_pnr='$pst_pnr'";
            $stmt = $pdo->query($query1);
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                $sql = "UPDATE gatepass_tbsignature SET signature = '$new_signature' WHERE pst_pnr = '$pst_pnr'";
                $pdo->exec($sql);
            } else {
                $sql = "INSERT INTO gatepass_tbsignature (pst_pnr, signature) VALUES ('$pst_pnr', '$new_signature')";
                $pdo->exec($sql);
            }



            $this->logindata['user']['signature'] = $new_signature;
            redirect('dashboard');

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>