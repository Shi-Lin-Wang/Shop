<?php
interface UserPaymentsManager
{
	public static function getPaymentObject();
	public static function getPaymentConfirm($transaction);
	public static function setAccount();
	public static function setReturnUrl();
	public static function setCancelUrl();
	public static function setCurrency($currency);
	
}
?>