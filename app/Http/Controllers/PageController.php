<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function execute($alias) {
//      если не существует вид
        if(!$alias) {
            abort(404);
        }

//        если конкретный вид существует
        if(view()->exists('site.page')) {

//            поле в БД 'alias' равно $alias({alias})
            $page = Page::where('alias', $alias)->first();

            $data = [
                'title' => $page->name,
                'page' => $page
            ];

            return view('site.page', $data);
        }
    }
}
