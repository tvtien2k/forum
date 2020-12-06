<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getCategory(Request $request)
    {
        $categories = Category::where('topic_id', '=', $request->topic_id)->get();
        foreach ($categories as $category) {
            echo "<option value=" . $category->id . ">" . $category->name . "</option>";
        }
    }
}
