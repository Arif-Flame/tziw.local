@extends('layouts.app')

@section('content')
    @auth
        <form method="POST" action="{{route("tasks.store")}}">
            <div class="container">


                <hr>
                @csrf
                <form>
                    <div class="form-group">
                        <label for="theme">Тема:</label>
                        <input class="form-control" type="text" id="theme" name="theme">
                    </div>
                    <div class="form-group">
                        <label for="message">Сообщение:</label>
                        <textarea  class="form-control" type="text" id="message" name="message" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Пользователь:</label>
                        <input disabled class="form-control" type="text" id="user_id" name="user_id" value="{{DB::table('users')->where('id',auth()->id())->value('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Почта:</label>
                        <input disabled class="form-control" type="text" id="user_email" name="user_email" value="{{DB::table('users')->where('id',auth()->id())->value('email')}}">
                    </div>
                    <div class="form-group">
                        <label for="files">Прикрепленные файлы:</label>
                        <input type="file" id="files" name="files" class="form-control-file custom-file"></input>
                    </div>
                    <div class="form-group">
                        <label for="time">Время создания:</label>
                        <input type="datetime-local" class="form-control" disabled value="{{\Carbon\Carbon::now('GMT+3')->toDateTimeLocalString()}}">
                    </div>

                    <button type="sumbit" class="btn btn-outline-info" >Отправить</button>
                </form>
            </div>
        </form>
    @endauth
@endsection
