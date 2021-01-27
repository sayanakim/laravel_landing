<div style="margin:0px 50px 0px 50px;">

    @if($services)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Название</th>
                <th>Текст</th>
                <th>Дата создания</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($services as $k => $service)

                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{!! Html::link(route('servicesEdit', ['service'=>$service->id]), $service->name, ['alt'=>$service->name]) !!}</td>
                    <td>{{ $service->text }}</td>
                    <td>{{ $service->icon }}</td>
                    <td>{!! $service->created_at !!}</td>

                    {{--             кнопка - удаление в админке--}}
                    <td>
                        {!! Form::open(['url'=>route('servicesEdit', ['service'=>$service->id]), 'class'=>'form-horizontal', 'method'=>'POST']) !!}

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

    <td>{!! Html::link(route('servicesAdd'), 'Новый сервис') !!}</td>

</div>
