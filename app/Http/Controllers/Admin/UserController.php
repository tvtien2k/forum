<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class UserController extends Controller{
    public function viewUser(){
        $user = User::all();
        return view('dashboard.pages.admin.user.view', [ 'user' => $user]);
    }

    public function getEdit($idU){
        $idU=DB::table('users')->where('id',$idU)->get();
        foreach ($idU as $u){
            $u=$u;
        }
        return view('dashboard.pages.admin.user.edit',['user'=>$u]);
    }
    public function postEdit(Request $request,$idU){
        $validator = $request->validate(['name' => 'required|min:2|max:250'], ['name.required' => 'Do not leave it blank',
            'name.min' => 'Need to enter 2 or more characters', 'name.max' => 'The number of characters exceeds the limit']);
        $idU=DB::table('users')->where('id',$idU)->get();
        foreach ($idU as $u){
            $u=$u;
        }
        $user=User::find($u->id);
        $user->name=$request->name;
        $user->gender = $request->gender;
        $user->level = $request->level;
        $user->save();
        return redirect('admin/manage-user/view');
    }
    public function delete($idU){
        $idU=DB::table('users')->where('id',$idU)->get();
        foreach ($idU as $u){
            $u=$u;
        }
        $post=DB::table('tbl_post')->where('author_id',$u->id)->get();
        foreach ($post as $p){
            $p_delete= Post::find($p->id);
            $p_delete->delete();
        }
        $user = User::find($u->id);
        $user->delete();
        return redirect('admin/manage-user/view');
    }
    public function banUser( Request $request,$id){
        if($request->datepicker==null){
            $user= User::find($id);
            $user->isBan=Carbon::now()->month.'/'.Carbon::now()->day.'/'.Carbon::now()->year;
            $user->save();
            return back()
                ->with('status', 'Ban successfully!');
        }
        else{
            $user= User::find($id);
            $user->isBan=$request->datepicker;
            $user->save();
            return redirect('admin/manage-user/view');
        }

    }
    public function banUserInClient(Request $request){
        $user= User::find($request->author);
        $date = date('m/d/Y');
        $newdate = strtotime ( '+2 day' , strtotime ( $date ) ) ;
        $newdate = date ( 'm/d/Y' , $newdate );
        $user->isBan= $newdate;
        $user->save();
         return back()
            ->with('status', 'Ban successfully!');
    }
}
