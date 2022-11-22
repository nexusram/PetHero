<?php
    namespace DAO;

    use Models\Coupon as Coupon;

    interface ICouponDAO{
        public function Add(Coupon $coupon);
        public function GetAllByIdKeeper($idkeeper);
        public function Remove($id);
    }
?>