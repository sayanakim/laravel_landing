<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $request) {

        //        Запрос DELETE
        if($request->isMethod('delete')) {
            $page->delete();
            return redirect('admin')->with('status', 'Страница удалена');
        }


        //        Запрос POST
        if ($request->isMethod('post')) {
    // вытаскивает данные из $request, кроме _token
            $input = $request->except('_token');
//            валидация с правилами
            $validator = Validator::make($input, [
                'name'=>'required|max:255',
                'alias'=>'required|max:255|unique:pages,alias,'.$input['id'],
                'text'=>'required'
            ]);

            if($validator->fails()) {
                return redirect()->route('pagesEdit', ['page'=>$input['id']])->withErrors($validator);
            }

    //        загружается ли опред.файл на сервер
            if($request->hasFile('images')) {
                $file = $request->file('images');
    //            копироваие файлов, путь куда будет сохранен файл
                $file->move(public_path().'/assets/img', $file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();
            }
            else {
    //            имя файла кот.был ранее зегружен
                $input['images'] = $input['old_images'];
            }
    //        загрузка на сервер, и что не нужно загружать
            unset($input['old_images']);
    //        заново заполняем модель
            $page->fill($input);
    //        перезаписывает модель в БД
            if($page->update()) {
                return redirect('admin')->with('status', 'Страница обновлена');
            };
        }


//        Запрос GET
//        $page = Page::find($id); // механизм внедрения
        $old = $page->toArray();
        if(view()->exists('admin.pages_edit')) {
            $data = [
                'title' => 'Редактирование страницы - '.$old['name'],
                'data' => $old
            ];
            return view('admin.pages_edit', $data);
        }

    }
}
