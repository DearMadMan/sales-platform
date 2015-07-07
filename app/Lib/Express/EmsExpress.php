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
    /**
     * [config initialize]
     * set defaults ,please
     */
    public function __construct()
    {
        $this->name = "EMS";
        $this->auth = 'wang';
        $this->code = 'ems';
        $this->desc = "EMS 国内邮政特快专递";
        $this->config = [
            'item_fee' => 20,   // 计量费用
            'base_fee' => 20,   // 基本费用
            'step_fee' => 15,   // 阶梯费用
            'free_money' => 300,  // 免费额度
            'settle_mode' => 'by_weight', //计算方式
            'input' => [
                [
                    'type' => 'text',
                    'label' => '500克以内费用：',
                    'name' => 'base_fee',
                    'value' => 15
                ],
                [
                    'type' => 'text',
                    'label' => '续重每500克或其零数的费用：',
                    'name' => 'step_fee',
                    'value' => 15
                ],
                [
                    'type' => 'text',
                    'label' => '免费额度：',
                    'name' => 'free_money',
                    'value' => 300
                ],
                [
                    'type' => 'select',
                    'label' => '计算方式：',
                    'name' => 'settle_mode',
                    'value' => 'by_weight',
                    'options' => [
                        'by_weight' => '按重量计算',
                        'by_number' => '按数量计算'
                    ]
                ]
            ]
        ];
    }

    public function settleAccount($amount, $number, $weight)
    {
        $free_money = floatval($this->free_money);
        $base_fee = floatval($this->base_fee);
        $item_fee = floatval($this->item_fee);
        $step_fee=floatval($this->step_fee);
        if ($free_money > 0 && $amount >= $free_money) {
            return 0;
        } else {
            $fee = $base_fee;
            $mode = $this->settle_mode ? $this->settle_mode : "by_weight";
            if ($mode == 'by_number') {
                $fee = $number * $item_fee;
            } else {
                if ($weight > 500) {
                    $fee += (ceil(($weight - 500) / 500)) * $step_fee;
                }
            }
            return $fee;
        }

    }
}