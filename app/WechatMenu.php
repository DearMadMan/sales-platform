<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class WechatMenu extends Model
{

    //
    public $timestamps = false;

    /*Manager_id*/
    private $m_id = 0;

    public function __construct ($m_id = 0)
    {
        $this->m_id = $m_id;
    }

    public function setMId ($m_id)
    {
        $this->m_id = $m_id;
    }

    /**
     * [获取微信一级菜单栏]
     * @param $manager_id 微信管理员ID编号
     * @return mixed
     */
    public function  getFirstMenu ()
    {
        return static::where ('manager_id' , $this->m_id)
            ->where ('parent_id' , 0)->get ();
    }

    /**
     * [获取当前各级菜单数目]
     * @param $manager_id
     * @param $parent_id
     * @return mixed
     */
    public function getMenuChildCount ($parent_id)
    {
        return static::where ('manager_id' , $this->m_id)
            ->where ('parent_id' , $parent_id)
            ->count ();
    }


    public function getMenuList ()
    {
        return static::where ('manager_id' , $this->m_id)
            ->orderBy ('parent_id' , 'asc')
            ->orderBy ('index' , 'desc')
            ->get ();
    }

    public function parent ()
    {
        return $this->hasOne ('App\WechatMenu' , 'id' , 'parent_id');
    }


    /**
     * [判断菜单能否设置]
     * @param $parent_id
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function CanSetParent ($parent_id)
    {

        $count = $this->getMenuChildCount ($parent_id);


        /* 变更前 判断自身下是否含有子菜单 */
        if ($this->id && $parent_id) {
            $child_count = $this->getMenuChildCount ($this->id);
            if ($child_count) {
                return redirect ()->back ()->WithInput ()
                    ->with ('tips' , "该菜单下还有子菜单");
            }
        }

        /* 如果是更新 并且菜单数据无变更 直接返回true */
        if ($this->id) {
            if ($this->parent_id == $parent_id) {
                return true;
            }
        }


        if ($parent_id == 0 && $count >= 3) {
            return redirect ()->back ()->WithInput ()
                ->with ('tips' , "一级菜单不能超过3个！");
        }
        if ($parent_id != 0 && $count >= 5) {
            return redirect ()->back ()->WithInput ()
                ->with ('tips' , "当前一级菜单的二级菜单不能超过5个！");
        }

        if ($parent_id != 0 && $this->id == $parent_id) {

            return redirect ()->back ()->WithInput ()
                ->with ('tips' , "请不要开这种玩笑。。自己怎么生自己！");
        }

        return true;
    }


    public function UpdateOrCreateFromRequest ($request)
    {
        $manager_id = $request->user ()->manager_id;
        $this->m_id = $manager_id;
        $parent_id = $request->get ('parent_id');
        $menu_type = $request->get ('menu_type');
        $name = $request->get ('name');
        $value = $request->get ('value');
        $index = intval (($request->get ('index')));

        /* 根据微信规则进行菜单写入判断 一级菜单不超过3个 2级菜单不超过5个 */

        $res = $this->CanSetParent ($parent_id);
        if ($res !== true) {
            return $res;
        }

        /* 插入数据库 */
        $this->manager_id = $manager_id;
        $this->parent_id = $parent_id;
        $this->menu_type = $menu_type;
        $this->name = $name;
        $this->value = $value;
        $this->index = $index;
        $this->save ();

        return true;
    }


    /**
     * [删除一级菜单及一级菜单下所有二级菜单]
     * @param $id
     */
    public function  DeleteFromFirstId ($id)
    {
        /* 如果是一级菜单 删除所有子菜单 */
        $menu = $this->Where ('parent_id' , $id)->get ();
        $ids = [$id];
        foreach ($menu as $k => $v) {
            array_push ($ids , $v['id']);
        }
        $this->destroy ($ids);
    }

    /**
     * [判断是否是一级菜单]
     * @param $id
     * @return bool
     */
    public function  isFirstMenu ($id)
    {
        $menu = $this->find ($id);
        if ($menu) {

            if ($menu->parent_id==0) {

                return true;
            }

        }
        return false;
    }

}
