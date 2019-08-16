@extends('layouts.app')

@section('content')
    @auth
        @if ($permission)
        <div class="container">

            <a href="{{route("tasks.index")}}"><i class="fas fa-chevron-left text-black-50 "> Вернуться назад...</i> </a>

            <div class="button-group">
                <input type="hidden" value="1" name="1">
                <form action="{{route("tasks.destroy", $item['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                <button class="btn btn-outline-danger float-right">Удалить</button></form>

            </div>

            <h3 class="text-black-50" >Заявка номер {{$item->id}}</h3>
            <hr>
            <form method="POST" action="{{route("tasks.update",$item->id)}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="theme">Тема:</label>
                    <input disabled class="form-control" type="text" id="theme" value="{{$item->theme}}">
                    <input hidden  class="form-control" type="text" name="theme" value="{{$item->theme}}">
                </div>
                <div class="form-group">
                    <label for="message">Сообщение:</label>
                    <textarea disabled class="form-control" type="text" id="message">{{$item->message}}</textarea>
                    <textarea hidden class="form-control" type="text" name="message">{{$item->message}}</textarea>
                </div>
                <div class="form-group">
                    <label for="user_name">Клиент:</label>
                    <input disabled class="form-control" type="text" id="user_id" name="user_name" value="{{DB::table('users')->where('id',auth()->id())->value('name')}}">
                    <input hidden class="form-control" type="text" id="user_id" name="user_name" value="{{DB::table('users')->where('id',auth()->id())->value('name')}}">
                </div>
                <div class="form-group">
                    <label for="user_email">Почта клиента:</label>
                    <input disabled class="form-control" type="text" id="user_email"  name="user_email" value="{{ DB::table('users')->where('id',$item->user_id)->value('email')}}">
                    <input hidden class="form-control" type="text" id="user_email"  name="email" value="{{ DB::table('users')->where('id',$item->user_id)->value('email')}}">
                </div>
                <div class="form-group">
                    <label for="files">Прикрепленные файлы:</label>
                    @foreach($filenames_array as $file)
                        <a href="{{route("downloadFile", $file)}}" download>{{$file}}</a>
                    @endforeach


                </div>
                <div class="form-group">
                    <label for="created_time">Время создания:</label>
                    <input type="text" disabled class="form-control" id="created_time" value="{{$item->created_at}}">
                </div>
                <hr class="dark">

                <div class="form-group">
                    <label for="created_time">Ответ:</label>
                    <textarea type="text" class="form-control" id="created_time" name="ansver" required placeholder="Ваш ответ..."></textarea>
                </div>
                <div class="button-group">

                        <button type="sumbit" class="btn btn-outline-info ">Отправить</button>


                </div>

            </form>
        </div>
            @else
            <h2>Нарушение прав доступа!</h2>
            @endif
    @endauth
@endsection
