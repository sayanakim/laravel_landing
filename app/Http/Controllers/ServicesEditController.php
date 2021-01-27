<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesEditController extends Controller
{
    public function execute(Service $service, Request $request) {

        //        Запрос DELETE
        if($request->isMethod('delete')) {
            $service->delete();
            return redirect('admin')->with('status', 'Сервис удален');
        }


        //        Запрос POST
        if ($request->isMethod('post')) {
            // вытаскивает данные из $request, кроме _token
            $input = $request->except('_token');
//            валидация с правилами
            $validator = Validator::make($input, [
                'name'=>'required|max:255',
                'text'=>'required',
                'icon'=>'required|max:255'
            ]);

            if($validator->fails()) {
                return redirect()->route('servicesEdit', ['service'=>$input['id']])->withErrors($validator);
            }


            //        загрузка на сервер, и что не нужно загружать
            if($request->hasFile('images')) {
                $file = $request->file('images');
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            }
            else {
                $input['images'] = $input['old_images'];
            }

            //        загрузка на сервер, и что не нужно загружать
            unset($input['old_images']);
            //        заново заполняем модель
            $service->fill($input);
            //        перезаписывает модель в БД
            if($service->update()) {
                return redirect('admin')->with('status', 'Сервис обновлен');
            };
        }


//        Запрос GET
//        $page = Page::find($id); // механизм внедрения
        $old = $service->toArray();
        if(view()->exists('admin.service_edit')) {
            $data = [
                'title' => 'Редактирование сервиса - '.$old['name'],
                'data' => $old
            ];
            return view('admin.services_edit', $data);
        }

    }
}

