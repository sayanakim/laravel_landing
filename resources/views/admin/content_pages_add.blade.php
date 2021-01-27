<div class="wrapper container-fluid">

    {!! Form::open(['url'=>route('pagesAdd'),'class'=>'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}

{{--    поле название--}}
        <div class="form-group">
            {!! Form::label('name', 'Название', ['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-8">
                {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Введите название страницы']) !!}
            </div>
        </div>

{{--поле псевдоним--}}
    <div class="form-group">
        {!! Form::label('alias', 'Псевдоним', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('alias', old('alias'), ['class'=>'form-control', 'placeholder'=>'Введите псевдоним страницы']) !!}
        </div>
    </div>

{{--поле текста--}}
    <div class="form-group">
        {!! Form::label('text', 'Текст', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::textarea('text', old('text'), ['id'=>'editor','class'=>'form-control', 'placeholder'=>'Введите текст']) !!}
        </div>
    </div>

{{--Поле для загрузки файлов--}}
    <div class="form-group">
        {!! Form::label('images', 'Изображение:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::file('images', ['class'=>'filestyle', 'data-buttonText'=>'Выберите изображение', 'data-buttonName'=>"btn-primary", 'data-placeholder'=>"Файла нет"]) !!}
        </div>
    </div>

{{--Кнопка "сохранить"--}}
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::button('Сохранить',['class'=>"btn btn-primary", 'type'=>'Submit']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <script>
        CKEDITOR.replace('editor')
    </script>
</div>

