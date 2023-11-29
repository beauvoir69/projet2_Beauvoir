<?php


class UserOrder extends Crud
{
    public function __construct($host, $db, $user, $password)
    {
        parent::__construct($host, $db, $user, $password);
    }

    public function getAllUserOrders()
    {
        return $this->getAll("user_order");
    }

    public function getUserOrderById($userOrderId)
    {
        return $this->getById("user_order", $userOrderId);
    }
