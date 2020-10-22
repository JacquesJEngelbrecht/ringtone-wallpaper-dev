@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($photos as $photo)
        <div class="col-md-8 mt-4">
            
            <div class="card">
                <div class="card-header">{{$photo->title}}</div>
                <div class="card-body">
                    <p>{{$photo->description}}</p>
                    <p>
                        <img src="/uploads/{{$photo->file}}" class="img-thumbnail">
                    </p>
                </div>
                
            </div>
        </div>
            <div class="col-md-3 mt-4">
                <p>
                <form action="{{route('download1', $photo->id)}}" method="POST">@csrf
                        <button class="btn btn-primary" type="submit">Download 1280x1024</button>
                    </form>
                </p>
                <p>
                    <form action="{{route('download2', $photo->id)}}" method="POST">@csrf
                        <button class="btn btn-primary" type="submit">Download 800x600</button>
                    </form>
                </p>
                <p>
                    <form action="{{route('download3', $photo->id)}}" method="POST">@csrf
                        <button class="btn btn-primary" type="submit">Download 315x255</button>
                    </form>
                </p>
                <p>
                    <form action="{{route('download4', $photo->id)}}" method="POST">@csrf
                        <button class="btn btn-primary" type="submit">Download 118x95</button>
                    </form>
                </p>        
            </div>
        @endforeach
        {{$photos->links()}}
    </div>
</div>
@endsection
