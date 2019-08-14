@extends('layouts.app')

@section('content')
    @auth
        <div class="container">
        <table class="table table-bordered">
            <thead class="thead-dark ">
            <tr>
                <th scope="col">№</th>
                <th scope="col">Тема</th>
                <th scope="col">Пользователь</th>
                <th scope="col">Дата</th>
            </tr>
            </thead>
            <tbody>
            @foreach($paging as $item)
                <tr>
                    <th scope="col">{{$item['id']}}
                    </th>
                    <th scope="col"> <a href="{{route ("tasks.edit", $item->id)}}">{{$item['theme']}}</a></th>
                    <th scope="col">{{
                    DB::table('users')->where('id', $item->user_id)->value('name')
                    }}</th>
                    <th scope="col">{{$item['created_at']}}</th>

                </tr>
            @endforeach
            </tbody>
        </table>
        @if($paging->total() > $paging->count())

            <div class="row align-content-center">
                <div class="col-12">
                    {{$paging->links()}}
                </div>
            </div>
        @endif
        </div>
    @endauth
@endsection
