<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Topic;
use Faker\Factory;
use Illuminate\Http\Request;

class InsertDataController extends Controller
{
    function to_slug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    function to_id($slug)
    {
        $arr = explode('-', $slug);
        $id = "";
        foreach ($arr as $v) {
            $id .= substr($v, 0, 1);
        }
        return strtoupper($id);
    }

    public function insertTopic()
    {
        $faker = Factory::create();
        for ($i = 1; $i < 3; $i++) {
            $topic = new Topic();
            $topic->name = $faker->sentence(1);
            $topic->slug = $this->to_slug($topic->name);
            $topic->id = $this->to_id($topic->slug) . '-' . $i;
            $topic->mod_id = $faker->numberBetween(2, 3);
            $topic->save();
            sleep(1);
        }
    }

    public function insertCategory()
    {
        $faker = Factory::create();
        for ($i = 1; $i < 11; $i++) {
            $cate = new Category();
            $cate->name = $faker->sentence(2);
            $cate->slug = $this->to_slug($cate->name);
            $cate->id = $this->to_id($cate->slug) . '-' . $i;
            $topics = Topic::all();
            $arr_topic_id = [];
            foreach ($topics as $topic) {
                array_push($arr_topic_id, $topic->id);
            }
            $cate->topic_id = $faker->randomElement($arr_topic_id);
            $cate->save();
            sleep(1);
        }
    }

    public function insertPost()
    {
        $faker = Factory::create();
        for ($i = 1; $i < 101; $i++) {
            $post = new Post();
            $post->author_id = $faker->numberBetween(1, 6);
            $categories = Category::all();
            $arr_categories_id = [];
            foreach ($categories as $category) {
                array_push($arr_categories_id, $category->id);
            }
            $post->category_id = $faker->randomElement($arr_categories_id);
            $post->title = $faker->sentence;
            $post->slug = $this->to_slug($post->title);
            $post->id = $this->to_id($post->slug) . '-' . $i;
            $post->description = $faker->text(300);
            $post->content = $faker->text(3000);
            $post->view = $faker->numberBetween(0, 1000);
            $post->status = $faker->randomElement(['post approval', 'post display']);
            $post->save();
            sleep(1);
        }
    }
}
