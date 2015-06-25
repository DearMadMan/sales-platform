<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodType extends Model
{

    public $timestamps = false;


    public function goods(){
        return $this->hasMany('App\Good','type_id','id');
    }

    public function getTypes($manager_id, $paginate = true)
    {
        if ($paginate) {
            return $this->where(['manager_id' => $manager_id])->Paginate(config("page.paginate"));
        }
        $types=$this->where('manager_id', $manager_id)->get();
        if($types->isEmpty()){
            $types=new self();
            $types->type_name="普通商品";
            $types->parent_id=0;
            $types->manager_id=$manager_id;
            $types->save();
        }
        return $types;
    }

    public function getType($manager_id, $id)
    {
        $type = $this->isOwn($manager_id, $id);
        return $type;

    }

    /**
     * [Store New Date to types]
     * @param $request
     * @return bool
     */
    public function StoreNew($request)
    {
        $manager_id = $request->user()->manager_id;
        $parent_id = $request->input('parent_id');
        /* root is zero */
        if ($parent_id) {
            $is_own = $this->IsOwn($manager_id, $parent_id);
            if (!$is_own) {
                return false;
            }
        }

        $type_name = $request->input('type_name');
        $this->type_name = $type_name;
        $this->parent_id = $parent_id;
        $this->manager_id = $manager_id;
        $this->save();
        return true;


    }

    /**
     * [ determine if type belongs to manager ]
     * @param $manager_id
     * @param $id
     * @return bool
     */
    public function IsOwn($manager_id, $id)
    {

        $row = $this->where(['manager_id' => $manager_id, "id" => $id])->first();
        if ($row) {
            return $row;
        }
        return false;

    }

    /**
     * [ Update ]
     * @param $request
     * @param $id
     * @return bool
     */
    public function UpdateType($request, $id)
    {
        $manager_id = $request->user()->manager_id;
        $parent_id = $request->input('parent_id');
        $type_name = $request->input('type_name');

        /* determine if parent_id is $id */
        if($parent_id==$id){
            return false;
        }

        $type = $this->IsOwn($manager_id, $id);
        if (!$type) {
            return false;
        }
        /* determine if parent_id belongs to manager */
        if ($parent_id) {
            $parent_type = $this->Isown($manager_id, $parent_id);
            if (!$type) {
                return false;
            }

            /* determine if parent_id is old children */
            $types = $this->getTypes($manager_id, false);
            $res = $this->HasChild($id, $parent_id, $types);
            if ($res) {
                return false;
            }
        }

        /* Update Date */
        $type->type_name = $type_name;
        $type->parent_id = $parent_id;
        $type->save();
        return true;

    }

    public function HasChild($parent_id, $id, $data)
    {
        while ($id != 0) {
            foreach ($data as $v) {
                if ($v->id == $id) {
                    $id = $v->parent_id;
                    if ($v->parent_id == $parent_id) {
                        return true;
                    }
                    break;
                }
            }
        }
        return false;
    }

    /**
     * [ Get All Parents ]
     * @param $id
     * @param $data
     * @return array
     */
    public function GetParents($id, $data)
    {
        $tree = [];
        while ($id != 0) {
            foreach ($data as $v) {
                if ($v->id == $id) {
                    $tree[] = $v;
                    $id = $v->parent_id;
                    break;
                }

            }
        }
        return $tree;
    }


    /**
     * [ Get Immediate Children ]
     * @param $data
     * @param $id
     * @return array
     */
    public function GetSons($data,$id=0){
        $sons=array();
        foreach($data as $item){
            if($item->parent_id==$id)
                $sons[]=$item;
        }
        return $sons;
    }


    /**
     * [ get all children]
     * @param $data  $this->getTypes($manager_id,false)
     * @param $id
     * @param int $level
     * @return array
     */
    public function GetChildren($data,$id,$level=1){
        $children=array();
        foreach($data as $item){
            if($item->parent_id==$id){
                $item->larevel=$level;
                $children[]=$item;
                $children=array_merge($children,$this->GetChildren($data,$item->id,$level+1));

            }

        }
        return $children;
    }

    public function GetParentTypeName(){
        if($this->parent_id==0)
        {
            return "顶级分类";
        }
        $type=$this->where('id',$this->parent_id)->first();
        if($type)
        {
            return $type->type_name;
        }
        return '';
    }

    /**
     * [ Delete GoodType ]
     * @param $manager_id
     * @param $id
     * @return bool
     */
    public function DeleteType($manager_id,$id){
        $type=$this->IsOwn($manager_id,$id);
        if($type)
        {
            /* determine if the type has children */
            if($type->parent_id)
            {
                $child=$this->where(['parent_id'=>$type->id,'manager_id'=>$manager_id])->first();
                if($child)
                {
                    return false;
                }
            }

            /* determine if the type has good */
            $good=Good::where('type_id',$type->id)->first();
            if($good)
            {
                return false;
            }
            $type->delete();
            return true;

        }
        return false;
    }


}
