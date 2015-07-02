<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2015/7/1
 * Time: 15:33
 * Email: 2034906607@qq.com
 */

namespace App\Lib\Express;

/**
 * 邮政快递包裹费用计算方式
 * ====================================================================================
 * 500g及500g以内                             20元
 * -------------------------------------------------------------------------------------
 * 续重每500克或其零数                        4元/6元/9元(按分区不同收费不同，具体分区方式，请寄件人拨打电话或到当地邮局营业窗口咨询，客服电话11185。)
 * -------------------------------------------------------------------------------------
 *
 */
class EmsExpress extends Contracts
{
    public function __construct()
    {
        $this->name = "EMS";
        $this->auth = 'wang';
        $this->code = 'ems';
        $this->desc = "EMS 国内邮政特快专递";
        $this->config = [
            'item_fee' => 20,
            'base_fee' => 20,
            'step_fee' => 15,
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