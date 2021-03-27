<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller{
    public function viewTopic(){
        $topic= Topic::all();
        return view('dashboard.pages.admin.topic.view',['topic'=>$topic]);
    }
    public function getAddTopic(){
        $user=User::all();
        $mod=[];
        $i=0;
        foreach ($user as $u){
            if($u->level==1){
                $mod[$i]=$u->id;
                $i+=1;
            }
        }
        $user1=DB::table('users')->whereIn('id',$mod)->get();
        return view('dashboard.pages.admin.topic.add',['user'=>$user1]);
    }
    public function postAddTopic(Request $request){
        $validator= $request->validate(['name'=>'required|min:2|max:250'],['name.required'=>'Do not leave it blank',
            'name.min'=>'Need to enter 2 or more characters','name.max'=>'The number of characters exceeds the limit']);
        $topic= new Topic;
        $topic1= Topic::all();
        $nameCut=[];
        $i=0;
        $count=DB::table('tbl_topic')->count();
        $mod=DB::table('users')->where('name',$request->mod_id)->get();
        foreach ($mod as $m){
            $m=$m;
        }
        if($count==0){
            $name=$request->name;
            $name= explode(" ",$name);
            foreach ($name as $n){
                $nameCut[$i]=$n[0];
                $i+=1;
            }
            $nameCut=implode("",$nameCut);
            $nameCut=strtoupper($nameCut)."-1";
            $topic->id=$nameCut;
            $topic->name=$request->name;
            $topic->slug=$request->slug;
            $topic->mod_id=$m->id;
            $topic->save();
            session()->flash('success', 'Created successfully');
            return $this->getAddTopic() ;
        }
        else{
            $topicLast = DB::table('tbl_topic')->latest()->first();
            $number =  explode('-', $topicLast->id);
            $number=(int)$number[1]+1;
            $name=$request->name;
            $name= explode(" ",$name);
            foreach ($name as $n){
                $nameCut[$i]=$n[0];
                $i+=1;
            }
            $nameCut=implode("",$nameCut);
            $nameCut=strtoupper($nameCut)."-".$number;
            $slug=implode("-",$name);
            $topic->id=$nameCut;
            $topic->name=$request->name;
            $topic->slug=$slug;
            $topic->mod_id=$m->id;
            $topic->save();
            session()->flash('success', 'Created successfully');
            return $this->getAddTopic() ;
        }
    }
    public function delete($id){
        $id_cate=[];
        $i=0;
        $topic = Topic::find($id);
        $category=DB::table('tbl_category')->where('topic_id',$topic->id)->get();
        foreach ($category as $ct){
            $id_cate[$i]=$ct->id;
            $i+=1;
        }
        $post=DB::table('tbl_post')->whereIn('category_id',$id_cate)->get();
        foreach ($post as $p){
            $p_delete=Post::find($p->id);
            $p_delete->delete();
        }
        foreach ($category as $c){
            $c_delete=Category::find($c->id);
            $c_delete->delete();
        }
        $topic->delete();
        return redirect('admin/manage-topic/view');
    }
    public function getEdit($id){
        $user=User::select('users.*')->where('level','=',1)->get();

        $idT=DB::table('tbl_topic')->where('id',$id)->get();
        foreach ($idT as $t){
            $t=$t;
        }
        return view('dashboard.pages.admin.topic.edit',['topic'=>$t,'user'=>$user]);
    }
    public function postEdit(Request $request,$id){
        $mod=DB::table('users')->where('name',$request->mod_id)->get();
        foreach ($mod as $m){
            $m=$m;
        }
        $topic=Topic::find($id);
        $topic->name=$request->name;
        $topic->slug=$request->slug;
        $topic->mod_id=$m->id;
        $topic->save();
        session()->flash('success', 'Edit successfully');
        return redirect('admin/manage-topic/view');

    }
}
