<div class="wrapper container-fluid">

    {!! Form::open(['url'=>route('servicesAdd'),'class'=>'form-horizontal', 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}

    {{--    поле название--}}
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Введите название сервиса']) !!}
        </div>
    </div>


    {{--поле текста--}}
    <div class="form-group">
        {!! Form::label('text', 'Текст', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::textarea('text', old('text'), ['id'=>'editor','class'=>'form-control', 'placeholder'=>'Введите текст']) !!}
        </div>
    </div>


    {{--поле иконки--}}
    <div class="form-group">
        {!! Form::label('icon', 'Иконка', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('icon', old('icon'), ['class'=>'form-control', 'placeholder'=>'Введите название иконки']) !!}
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

