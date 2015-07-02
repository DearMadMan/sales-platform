<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2015/7/1
 * Time: 15:34
 * Email: 2034906607@qq.com
 */

namespace App\Lib\Express;


class SFExpress extends Contracts
{
    public function __construct()
    {
        $this->name = "顺丰速运";
        $this->auth = 'wang';
        $this->code = 'shunfeng';
        $this->desc = "江、浙、沪地区首重15元/KG，续重2元/KG，其余城市首重20元/KG";
        $this->config = [
            'item_fee' => 20,
            'base_fee' => 15,
            'step_fee' => 2,
        ];
    }

    public function settleAccount($amount, $number, $weight)
    {
        if ($this->free_money > 0 && $amount >= $this->free_money) {
            return 0;
        } else {
            $fee = $this->base_fee;
            $mode = $this->settle_mode ? $this->settle_mode : "by_weight";
            if ($mode == 'by_number') {
                $fee = $number * $this->item_fee;
            } else {
                if ($weight > 1000) {
                    $fee += (ceil(($weight - 1000) / 1000)) * $this->step_fee;
                }
            }
            return $fee;
        }

    }
}