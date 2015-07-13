<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpressArea extends Model
{
    //
    public $timestamps = false;

    public function updateConfig($request, $express)
    {
        $express_area = $this->exists($request->express_area_id);
        if (!$express_area) {
            return false;
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
                    return $express->ajaxResponse(2, 'Unknown Express Config\'s Property:' . $k);
                $v = $express_config->$k;
            }
            $config[$k] = $v;
        }
        /* Update to express_areas */

        $express_area->name = $config['name'];
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
        $express_area_region->where('express_area_id',$express_area->id)->delete();
        $express_area_region->insert($arr);

        /* return data */
        $data = [
            'id' => $express_area->id,
            'name' => $express_area->name,
            'regionNames' => str_limit($express->getDeliverRegionNames($express_area->id), 50)
        ];


        return $express->ajaxResponse(100, 'Update Success', $data);


    }

    public function exists($id)
    {
        return $this->where('id', $id)->first();
    }

}
