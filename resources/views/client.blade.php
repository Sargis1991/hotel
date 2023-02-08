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
        <div>
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        @if ($errors->has('from'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{$errors->first('from')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->has('to'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{$errors->first('to')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Rooms
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="row">
                                @forelse ($rooms as $room)
                                    @include('clientRoom',['room'=>$room])
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        My reservations <button id="edit" class="btn btn-warning float-end">Edit</button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @forelse(auth()->user()->rooms()->get() as $reserve )
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <form class="formBox" method="POST" action="{{route('change',$reserve->pivot->id)}}">
                                            @csrf
                                            @method('PUT')
                                            Room Name {{$reserve->number}}
                                            <div>
                                                <input name="from" class="datepicker" value=" {{  \Carbon\Carbon::parse($reserve->pivot->from)->format('m/d/Y')}}"  disabled>
                                                <input name="to" class="datepicker" value=" {{  \Carbon\Carbon::parse($reserve->pivot->to)->format('m/d/Y')}}"  disabled>
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class=" btn btn-primary" disabled>Change</button>
                                                <a href="{{route('cancel',$reserve->pivot->id)}}" class="btn btn-danger">Remove</a>
                                            </div>
                                        </form>

                                    </li>
                                @empty
                                You dont have a reservations yet
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({
                format: 'mm/dd/yyyy',
                startDate: new Date()
            });

            $('#edit').click(function (){
                $('.formBox input').prop( "disabled", false )
                $('.formBox button').prop( "disabled", false )
            })
        });
    </script>



@endsection
