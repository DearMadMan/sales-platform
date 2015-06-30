<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    //
    public function manager()
    {
        return $this->belongsTo('App\WechatManager', 'manager_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\ArticleType', "type_id", "id");
    }

    /**
     * [ get Recycles list from articles ]
     * @param $manager_id
     * @param bool $paginate
     * @return mixed
     */
    public function getRecycles($manager_id, $paginate = true)
    {
        if ($paginate) {
            $articles = $this->where([
                'manager_id' => $manager_id,
                'is_delete' => true
            ])->Paginate(config('page.paginate'));
        } else {
            $articles = $this->where([
                'manager_id' => $manager_id,
                'is_delete' => true
            ])->get();
        }

        return $articles;
    }

    public function Restore($manager_id,$id){
        $article=$this->GetArticle($manager_id,$id);
        if($article)
        {
            $article->is_delete=false;
            $article->save();
            return true;
        }
        return false;
    }

    public function GetArticle($manager_id,$id){
        return $this->where(['manager_id'=>$manager_id,"id"=>$id])->first();
    }

    public function Recycle( $manager_id,$id){
        $article=$this->GetArticle($manager_id,$id);
        if($article){
            $article->is_delete=true;
            $article->save();
            return true;
        }
        return false;

    }

}
