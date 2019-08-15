@extends('layouts.app')

@section('content')
    @auth
        <form method="POST" action="{{route('tasks.store')}}" enctype="multipart/form-data">
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
                        <input disabled class="form-control" type="text" id="user_id" name="user_name" value="{{DB::table('users')->where('id',auth()->id())->value('name')}}">
                        <input hidden class="form-control" type="text" id="user_id" name="user_name" value="{{DB::table('users')->where('id',auth()->id())->value('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="user_email">Почта:</label>
                        <input disabled class="form-control" type="text" id="user_email" name="email" value="{{DB::table('users')->where('id',auth()->id())->value('email')}}">
                        <input hidden class="form-control" type="text" id="email" name="email" value="{{DB::table('users')->where('id',auth()->id())->value('email')}}">
                    </div>
                    <div class="form-group">
                        <label for="files">Прикрепленные файлы:</label>
                        <input type="file" id="files" multiple name="files[]" class="form-control-file custom-file" onchange="checkFileInput()"></input>
                        <input hidden type="file" id="files_hidden" multiple name="files[]"></input>
                    </div>
                    <div class="form-group">
                        <label for="time">Время создания:</label>
                        <input type="datetime-local" class="form-control" disabled value="{{\Carbon\Carbon::now('GMT+3')->toDateTimeLocalString()}}">
                    </div>

                    <button type="sumbit" class="btn btn-outline-info" >Отправить</button>
                </form>
            </div>
        </form>
 <script>
function checkFileInput(){
    var elem = document.getElementById("files");
    if(elem.files.length >= 2){
        // elem.files = Array.prototype.slice.call( elem.files, 0, 15); //Then simply use the slice arguments at your convenience
        document.getElementById("files_hidden").files = elem.files;
        console.log(elem.files);
        elem.setAttribute('disabled', "true");
    }
}
</script>       
    @endauth
@endsection
