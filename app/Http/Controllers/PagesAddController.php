<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;



class PagesAddController extends Controller
{
    public function execute(Request $request)
    {
        if ($request->isMethod('post')) {

//            убираем поле _token
            $input = $request->except('_token');
//            dd($input);


            // сообщения об ошибках
            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'
            ];

//            Валидатор - правильность данных(правило)
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'
            ], $messages);

//            Если есть ошибки в валидации, то применяется:
            if($validator->fails()) {
                return redirect()->route('pagesAdd')
                                ->withErrors($validator)
                                ->withInput();
            }

//            загружаем картинки в БД
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                // загрузка картинки на сервер
                $file->move(public_path().'/assets/img', $input['images']);

            };
            // модель
            $page = new Page();
//            $page->unguard();
            $page->fill($input);
//          сохраняем
            if ($page->save()) {
                return redirect('admin')->with('status', 'Страница добавлена');
            }
        }

        if (view()->exists('admin.pages_add')) {
            $data = [
                'title' => 'Новая страница'
            ];
            return view('admin.pages_add', $data);
        }

        abort(404);
    }
}
