<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesAddController extends Controller
{
    public function execute(Request $request) {

        // если метод post
        if($request->isMethod('post')) {

            // исключаем поле _token
            $input = $request->except('_token');

            // сообщения об ошибках валидации
            $message = [
                'required'=>'Поле :attribute обязательно к заполнению'
            ];

            // валидация - проверка на правильность введенных данных
            $validator = Validator::make($input, [
                'name'=>'required|max:255',
                'text'=>'required',
                'icon'=>'required|max:255'
            ], $message);

            // Если есть ошибки в валидации, то применяется:
            if($validator->fails()) {
                return redirect()->route('servicesAdd')
                                ->withErrors($validator)
                                ->withInput();
            }

            // модель
            $service = new Service();
            $service->fill($input);
            // сохраняем
            if($service->save()) {
                return redirect('admin')->with('status', 'Сервис обновлен');
            }
        }

        // проверка на наличие представления
        if(view()->exists('admin.services_add')) {
            $data = [
                'title'=>'Новый сервис'
            ];
            return view('admin.services_add', $data);
        }
        abort(404);



    }
}
