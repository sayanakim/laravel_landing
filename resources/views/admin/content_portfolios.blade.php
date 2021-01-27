<div style="margin:0px 50px 0px 50px;">

    @if($portfolios)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Имя</th>
                <th>Картинка</th>
                <th>Фильтр</th>
                <th>Дата создания</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($portfolios as $k => $portfolio)

                <tr>
                    <td>{{ $portfolio->id }}</td>
                    <td>{!! Html::link(route('portfoliosEdit', ['portfolio'=>$portfolio->id]), $portfolio->name, ['alt'=>$portfolio->name]) !!}</td>
                    <td>{!! $portfolio->images !!}</td>
                    <td>{!! $portfolio->filter !!}</td>
                    <td>{!! $portfolio->created_at !!}</td>

                    {{--             кнопка - удаление в админке--}}
                    <td>
                        {!! Form::open(['url'=>route('portfoliosEdit', ['portfolio'=>$portfolio->id]), 'class'=>'form-horizontal', 'method'=>'POST']) !!}

                        {{-- 1 способ                   {!! Form::hidden('_method', 'delete') !!}--}}
                        {{--                    2 способ--}}
                        {{--                    формирует <input type="hidden" name="_method" value="DELETE">--}}
                        {!! method_field('DELETE') !!}
                        {!! Form::button('Удалить', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    @endif

    <td>{!! Html::link(route('portfoliosAdd'), 'Новое портфолио') !!}</td>

</div>
