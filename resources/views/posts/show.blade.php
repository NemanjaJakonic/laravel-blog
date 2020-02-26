@extends('layouts.app')

@section('content')
{{--    <a href="/posts" class="btn btn-outline-dark float-right mt-3 mr-3">Go back</a>--}}
    <div class="post-body">
    <h1 class="text-center mt-3">{{$post->title}}</h1>
    <img style="width:100%" src="{{secure_asset('/uploads/cover_images').'/'.$post->cover_image}}" alt="">
    <br><br>
    <div class="post-body">
        {!! $post->body !!}
    </div>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    <div class="row">
        <div class="col-md">
            <h3 class="text-center mb-5"><strong>Comments:</strong></h3>
            @foreach($post->comments as $comment)

                <p>{{$comment->comment}}</p>
                <small>Commented on {{$comment->created_at}} by <strong>{{$comment->name}}</strong></small>
                <hr>
            @endforeach
        </div>
    </div>
    </div>


    @if(Auth::guest())
    {{Form::open(['route'=>['comments.store',$post->id],'method'=>'POST'])}}
    <div class="comments-body">
    <div class="row">
        <div class="col-md-6">
            {{Form::label('name',"Name:")}}
            {{Form::text('name',null,['class'=>'form-control'])}}
        </div>
        <div class="col-md-12">
            {{Form::label('comment',"Comment:")}}
            {{Form::textarea('comment',null,['class'=>'form-control','rows'=>'5'])}}
            {{Form::submit('Add Comment',['class'=>'btn mt-3 btn-success'])}}
        </div>
    </div>
    </div>
        @elseif(Auth::user()->id!=$post->user_id)
        <div class="comments-body">
        <div class="row">
            <div class="col-md-6">
                {{Form::label('name',"Name:")}}
                {{Form::text('name',null,['class'=>'form-control'])}}
            </div>
            <div class="col-md-12">
                {{Form::label('comment',"Comment:")}}
                {{Form::textarea('comment',null,['class'=>'form-control','rows'=>'5'])}}
                {{Form::submit('Add Comment',['class'=>'btn mt-3 btn-success'])}}
            </div>
        </div>
        </div>
    @endif
    @if(!Auth::guest())
        @if(Auth::user()->id==$post->user_id)
            <div class="user-edit">
            <a href="
        /posts/{{$post->id}}/edit" class="btn btn-outline-dark mb-3 ml-3">Edit</a>
            {!!Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete',['class'=>'btn btn-danger mb-3 mr-3'])}}
            {!!Form::close()!!}
            </div>
        @endif
    @endif
@endsection
