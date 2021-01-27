<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Validator;

class PortfoliosEditController extends Controller
{
    public function execute(Portfolio $portfolio, Request $request) {

        if($request->isMethod('delete')) {
            $portfolio->delete();
            return redirect('admin')->with('status', 'Портфолио удалено');
        }

        // запрос POST
        if($request->isMethod('post')) {
            // вытаскивает данные из $request, кроме _token
            $input = $request->except('_token');
            // валидация с правилами
            $validator = Validator::make($input, [
                'name'=>'required|max:255|',
                'images'=>'required',
                'filter'=>'required'
            ]);

            if ($validator->fails()) {
                return redirect()->route('portfoliosEdit', ['portfolio'=>$input['id']])->withErrors($validator);
            }

            //загружается ли опред.файл на сервер
            if($request->hasFile('images')) {
                $file = $request->file('images');
                // копироваие файлов, путь куда будет сохранен файл
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            }
            else {
//                имя файла кот.был ранее зегружен
                $input['images'] = $input['old_images'];
            }
            // загрузка на сервер, и что не нужно загружать
            unset($input['old_images']);
            // заново заполняем модель
            $portfolio->fill($input);
            // перезаписывает модель в БД
            if($portfolio->update()) {
                return redirect('admin')->with('status', 'Портфолио обновлено');
            }
        }


        //        Запрос GET
        $old = $portfolio->toArray();
        if(view()->exists('admin.portfolios_edit')) {
            $data = [
                'title'=>'Редактирование портфолио - '.$old['name'],
                'data'=> $old
            ];
            return view('admin.portfolios_edit', $data);
        }
    }
}
