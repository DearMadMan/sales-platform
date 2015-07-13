<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Translation\Interval;

class Express extends Model
{
    //
    public $timestamps = false;

    /**
     * [ get Express list if it's belongs manager_id]
     * @param $manager_id
     * @return mixed
     */
    public function getExpresses($manager_id)
    {
        return $this->where('manager_id', $manager_id)->get();
    }

    /**
     * [ get Express by manager_id and code ]
     * @param $manager_id
     * @param $code
     * @return mixed
     */
    public function hasExpress($manager_id, $code)
    {
        return $this->where(['manager_id' => $manager_id, 'code' => $code])->first();
    }

    /**
     * [ get Express by manger_id and id ]
     * @param $manager_id
     * @param $id
     * @return mixed
     */
    public function existExpress($manager_id, $id)
    {
        return $this->where(['manager_id' => $manager_id, 'id' => $id])->first();
    }


    /**
     * [ Add new DeliverRegion for special express ]
     * @param $request
     * @return bool
     */
    public function storeDeliverRegion($request)
    {
        $id = $request->input("id");
        $manager_id = $request->user()->manager_id;
        /* Determine if id is illegal */
        $express = $this->existExpress($manager_id, $id);
        if (!$express) {
            return $this->ajaxResponse(1, 'Unknown Express!', '');
        }
        $express_config = json_decode($express->config);
        $config = [];
        $inputs = $request->all();
        if (empty($inputs['areas'])) {
            $inputs['areas'] = 1;
        }
        foreach ($inputs as $k => $v) {
            $k = trim($k);
            if ($k == "_token" || $k == "_method" || $k == "id")
                break;
            $v = trim($v);
            if (empty($v)) {
                if (!property_exists($express_config, $k))
                    return $this->ajaxResponse(2, 'Unknown Express Config\'s Property:' . $k);
                $v = $express_config->$k;
            }
            $config[$k] = $v;
        }
        /* insert to express_areas */
        $express_area = new ExpressArea();
        $express_area->name = $config['name'];
        $express_area->express_id = $id;
        $express_area->config = json_encode($config);
        $express_area->save();

        /* insert to express_area_regions */
        $regions = $inputs['areas'];
        $regions = trim($regions, ',');
        $regions = explode(',', $regions);
        $express_area_region = new ExpressAreaRegion();
        $arr = [];
        foreach ($regions as $v) {
            $arr[] = [
                'express_area_id' => $express_area->id,
                'region_id' => $v
            ];
        }
        $express_area_region->insert($arr);

        /* return data */
        $data = [
            'id' => $express_area->id,
            'name' => $express_area->name,
            'regionNames' => str_limit($this->getDeliverRegionNames($express_area->id), 50)
        ];


        return $this->ajaxResponse(0, 'Insert Success', $data);

    }

    /**
     * @param $code
     * 0 : store success
     * 100 : update success
     * !0 : failed
     * @param $msg
     * @param $data
     * @return string
     */
    public function ajaxResponse($code, $msg, $data = '')
    {
        if (!is_string($msg))
            $msg = "Unknown Message！";
        $arr = [
            'code' => intval($code),
            'msg' => $msg,
            'data' => $data
        ];
        return json_encode($arr);
    }

    public function getDeliverRegions($express_id)
    {
        $express_area = new ExpressArea();
        $res = $express_area->where('express_id', $express_id)->get();
        if (!$res->isEmpty()) {
            foreach ($res as $k => $v) {
                $res[$k]->regionNames = $this->getDeliverRegionNames($v->id);
            }
        }
        return $res;
    }

    public function getDeliverRegionNames($express_area_id)
    {
        $regions = new ExpressAreaRegion();
        $names = $regions->getRegionNames($express_area_id);

        return $names;
    }

}
