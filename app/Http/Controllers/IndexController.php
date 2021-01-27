<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function execute(Request $request) {

        //отправка сообщений на почту
        if ($request->isMethod('post')) {

            // правило введения обязательных сообщений
            $messages =[
                'required'=>"Поле :attribute обязатeльно к заполнению",
                'email'=>"Поле :attribute должно соответсвовать email адресу"
            ];

            // правило валидации
            $request->validate([
                'name'=>'required|max:255',
                'email'=>'required|email',
                'text'=>'required'
            ], $messages);

            // проверка на отправку
//            dump($request);

            // получаем все отправленные пользователем данные
            $data = $request->all();
            dump($data);

            // отправка пользователем сообщений на email
            Mail::send('site.email', ['data'=>$data], function ($message) use ($data) {
                $mail_admin = env('MAIL_ADMIN');
                // от кого(пользователь) отправляется
                $message->from($data['email'], $data['name']);
                // к кому(админу) отправляется
                $message->to($mail_admin, 'Mr. Admin')->subject('Question');
            });
            return redirect()->route('home')->with('status', 'Email is send');
        }

        // Подключение к БД
        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

//         filter
        $tags = DB::table('portfolios')->distinct()->get('filter');
//        dd($tags);

        // заполнение контентом страницы
        // динамические пункты меню
        $menu = array();
        foreach ($pages as $page) {
            $item = ['title'=>$page->name, 'alias'=>$page->alias];
            array_push($menu, $item);
        }

        // формируем меню
        // статические пункты меню
        // добавляем в ручную
        // аналог верстки:
//                <li class="active"><a href="#hero_section" class="scroll-link">Home</a></li>
//                <li><a href="#aboutUs" class="scroll-link">About Us</a></li>
//                <li><a href="#service" class="scroll-link">Services</a></li>
//                <li><a href="#Portfolio" class="scroll-link">Portfolio</a></li>
//                <li><a href="#team" class="scroll-link">Team</a></li>
//                <li><a href="#contact" class="scroll-link">Contact</a></li>

        $item = ['title'=>'Services', 'alias'=>'service'];
        array_push($menu, $item);

        $item = ['title'=>'Portfolio', 'alias'=>'Portfolio'];
        array_push($menu, $item);

        $item = ['title'=>'Team', 'alias'=>'team'];
        array_push($menu, $item);

        $item = ['title'=>'Contact', 'alias'=>'contact'];
        array_push($menu, $item);

        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags
        ]);
    }
}
