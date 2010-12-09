<?php
class CouponModel extends Model{
	function __construct(){
		$this->db = parent::dbConnect($GLOBALS ["gDataBase"] ["db"]);
	}
	function getAllBrand(){
		return $this->db->getAll("select * from coupon_brand");
	}
	function getBrand($b_id){
		return $this->db->getAll("select * from coupon_brand where b_id=$b_id");
	}
	function getCouponlist($b_id){
		return $this->db->getAll("select * from coupon where b_id=$b_id order by cp_date desc");
	}
	function getCoupon($cp_id){
		return $this->db->getAll("select * from coupon where cp_id=$cp_id");
	}
	function getNewCoupon($b_id){
		return $this->db->getAll("select * from coupon where b_id=$b_id order by cp_date desc limit 0,1");
	}
}

?>