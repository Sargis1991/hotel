@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ $message }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Rooms
                    <div class="d-inline-block float-end">
                        <a href="{{route('rooms.create')}}" class="btn btn-primary">Add Room</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <div class="row">
                       @forelse ($rooms as $room)
                           @include('room',['room'=>$room])
                       @empty
                           <p>No Rooms</p>
                       @endforelse
                   </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{$rooms->links()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
