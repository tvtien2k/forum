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
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->sentence(2);
            $slug = $this->to_slug($name);
            $topic_latest = Topic::latest()->first();
            if ($topic_latest) {
                $index = (int)explode('-', $topic_latest->id)[1] + 1;
                $id = $this->to_id($slug) . '-' . $index;
            } else {
                $id = $this->to_id($slug) . '-1';
            }
            $mod_id = $faker->numberBetween(1, 100);
            $topic = new Topic();
            $topic->id = $id;
            $topic->name = $name;
            $topic->slug = $slug;
            $topic->mod_id = $mod_id;
            $topic->save();
            sleep(1);
        }
    }

    public function insertCategory()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $name = $faker->sentence(3);
            $slug = $this->to_slug($name);
            $cate_latest = Category::latest()->first();
            if ($cate_latest) {
                $index = (int)explode('-', $cate_latest->id)[1] + 1;
                $id = $this->to_id($slug) . '-' . $index;
            } else {
                $id = $this->to_id($slug) . '-1';
            }
            $topics = Topic::all();
            $arr_topic_id = [];
            foreach ($topics as $topic) {
                array_push($arr_topic_id, $topic->id);
            }
            $topic_id = $faker->randomElement($arr_topic_id);
            $cate = new Category();
            $cate->id = $id;
            $cate->name = $name;
            $cate->slug = $slug;
            $cate->topic_id = $topic_id;
            $cate->save();
            sleep(1);
        }
    }

    public function insertPost()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $title = $faker->sentence;
            $slug = $this->to_slug($title);
            $post_latest = Post::latest()->first();
            if ($post_latest) {
                $index = (int)explode('-', $post_latest->id)[1] + 1;
                $id = $this->to_id($slug) . '-' . $index;
            } else {
                $id = $this->to_id($slug) . '-1';
            }
            $author_id = $faker->numberBetween(1, 100);
            $categories = Category::all();
            $arr_categories_id = [];
            foreach ($categories as $category) {
                array_push($arr_categories_id, $category->id);
            }
            $category_id = $faker->randomElement($arr_categories_id);
            $content = $faker->text(5000);
            $status = $faker->randomElement(['approval', 'display']);
            $is_post = true;
            $allow_comment = true;
            $post = new Post();
            $post->id = $id;
            $post->author_id = $author_id;
            $post->category_id = $category_id;
            $post->title = $title;
            $post->slug = $slug;
            $post->content = $content;
            $post->status = $status;
            $post->is_post = $is_post;
            $post->allow_comment = $allow_comment;
            $post->save();
            sleep(1);
        }
    }
}
