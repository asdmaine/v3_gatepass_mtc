<?php
$this->logindata['user'] = $this->session->userdata('auth');
$this->logindata['user']['signature'] = $this->m_admin->getSignature($this->logindata['user']['pst_pnr']);


// cek didatabase apakah pst_pnr yang login ada di verifikasi1/verifikasi2/approval1/approval2
$count = $this->m_admin->GetLevel($this->logindata['user']['pst_pnr']);
if($count > 0){
	$this->logindata['level'] = 'verifikator';
}else{
	$this->logindata['level'] = 'biasa';
}
$count = $this->m_admin->isSecurity($this->logindata['user']['pst_pnr']);
if($count > 0){
	$this->logindata['level'] = 'security';
}
$this->logindata['user']['jobtl_name'] = strtoupper($this->logindata['user']['jobtl_name']);
if(strpos($this->logindata['user']['jobtl_name'],'HR') !== false || strpos($this->logindata['user']['jobtl_name'],'TIME') !== false){
	$this->logindata['hr']=true;
}

?>