<?php

class ProductModel extends ActiveRecord implements CartItemInterface
{

    public function getPrice()
    {
        return $this->price;
    }

    public function getLabel()
    {
        return $this->name;
    }

    public function getUniqueId()
    {
        return $this->id;
    }
}
