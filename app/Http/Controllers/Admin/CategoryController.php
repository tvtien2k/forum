<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function viewCate()
    {
        $topic=Topic::all();
        $cate=Category::all();
        return view('dashboard.pages.admin.category.view', [ 'cate' => $cate,'topic'=>$topic]);
    }

    public function getAddCate()
    {
        $topic=Topic::all();
        return view('dashboard.pages.admin.category.add', ['topic'=>$topic]);
    }

    public function postAddCate(Request $request)
    {
        $validator= $request->validate(['name'=>'required|min:2|max:250'],['name.required'=>'Do not leave it blank',
            'name.min'=>'Need to enter 2 or more characters','name.max'=>'The number of characters exceeds the limit']);
        $cate = new Category;
        $nameCut = [];
        $i = 0;
        $count = DB::table('tbl_category')->count();
        $topic=DB::table('tbl_topic')->where('name',$request->topic_id)->get();
        foreach ($topic as $t){
            $t=$t;
        }
        if ($count == 0) {
            $name = $request->name;
            $name = explode(" ", $name);
            foreach ($name as $n) {
                $nameCut[$i] = $n[0];
                $i += 1;
            }
            $nameCut = implode("", $nameCut);
            $nameCut = strtoupper($nameCut) . "-1";
            $cate->id = $nameCut;
            $cate->name = $request->name;
            $cate->slug = $request->slug;
            $cate->topic_id = $t->id;
            $cate->save();
            session()->flash('success', 'Created successfully');
            return view('dashboard.pages.admin.category.add',['topic'=>$topic]);
        } else {
            $cateLast = DB::table('tbl_category')->latest()->first();
            $number = explode('-', $cateLast->id);
            $number = (int)$number[1] + 1;
            $name = $request->name;
            $name = explode(" ", $name);
            foreach ($name as $n) {
                $nameCut[$i] = $n[0];
                $i += 1;
            }
            $nameCut = implode("", $nameCut);
            $nameCut = strtoupper($nameCut) . "-" . $number;
            $slug = implode("-", $name);
            $cate->id = $nameCut;
            $cate->name = $request->name;
            $cate->slug = $slug;
            $cate->topic_id = $t->id;
            $cate->save();
            session()->flash('success', 'Created successfully');
            return view('dashboard.pages.admin.category.add', ['topic'=>$topic]);
        }
    }
    public function delete($id){
        $cate = Category::find($id);
        $post=DB::table('tbl_post')->whereIn('category_id',$cate)->get();
        foreach ($post as $p){
            $p_delete=Post::find($p->id);
            $p_delete->delete();
        }
        $cate->delete();
        return redirect('admin/manage-category/view');
    }
    public function getEdit($id){
        $topic=Topic::all();
        $idC=DB::table('tbl_category')->where('id',$id)->get();
        foreach ($idC as $c){
            $c=$c;
        }
        return view('dashboard.pages.admin.category.edit',['cate'=>$c,'topic'=>$topic]);
    }
    public function postEdit(Request $request,$id){
        $topic=DB::table('tbl_topic')->where('name',$request->topic_id)->get();
        foreach ($topic as $t){
            $t=$t;
        }
        $cate=Category::find($id);
        $cate->name=$request->name;
        $cate->slug=$request->slug;
        $cate->topic_id=$t->id;
        $cate->save();
        return redirect('admin/manage-category/view');

    }
    public function filter(Request  $request){
        $topic=Topic::all();
        $topicC=$request->topic;
        $cate=Category::select('tbl_category.*')
            ->where('topic_id','=',$request->topic)
            ->get();
        return view('dashboard.pages.admin.category.view', [ 'cate' => $cate,'topic'=>$topic,'topicC'=>$topicC]);
    }
}

