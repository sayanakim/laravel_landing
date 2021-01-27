<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfoliosAddController extends Controller
{
    public function execute(Request $request)
    {
        // если метод POST
        if ($request->isMethod('post')) {
//            dump($request);
//            убираем поле _token
            $input = $request->except('_token');
//            dd($input);


            // сообщения об ошибках
            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'unique' => 'Поле :attribute должно быть уникальным'
            ];

//            валидация
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'images' => 'required',
                'filter' => 'required'
            ], $messages);

//            ошибки в валидации
            if ($validator->fails()) {
                return redirect()->route('portfoliosAdd')
                                ->withErrors($validator)
                                ->withInput();
            }

//            загрузка картинок в БД
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                // загрузка картинки на сервер
                $file->move(public_path().'/assets/img', $input['images']);
            }

            // модель
            $portfolio = new Portfolio();
            $portfolio->fill($input);
//            сохряняем
            if ($portfolio->save()) {
                return redirect('admin')->with('status', 'Портфолио добавлено');
            }

        }

        // если есть представление
        if (view()->exists('admin.portfolios_add')) {
            $data = [
                'title' => 'Новое портфолио'
            ];
            return view('admin.portfolios_add', $data);
        }
        abort(404);
    }
}
