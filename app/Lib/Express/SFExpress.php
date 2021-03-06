<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2015/7/1
 * Time: 15:34
 * Email: i@dearmadman.com
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
            'free_money'=>300,
            'settle_mode'=>'by_weight', //计算方式
            'input'=>[
                [
                    'type'=>'text',
                    'label'=>'1000克以内费用：',
                    'name'=>'base_fee',
                    'value'=>15
                ],
                [
                    'type'=>'text',
                    'label'=>'续重每1000克或其零数的费用：',
                    'name'=>'step_fee',
                    'value'=>15
                ],
                [
                    'type'=>'text',
                    'label'=>'免费额度：',
                    'name'=>'free_money',
                    'value'=>300
                ],
                [
                    'type'=>'select',
                    'label'=>'计算方式：',
                    'name'=>'settle_mode',
                    'value'=>'by_weight',
                    'options'=>[
                        'by_weight'=>'按重量计算',
                        'by_number'=>'按数量计算'
                    ]
                ]
            ]
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