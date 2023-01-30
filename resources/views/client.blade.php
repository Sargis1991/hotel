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
        @if ($errors->has('date'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{$errors->first('date')}}</strong>
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
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({
                format: 'mm/dd/yyyy',
                startDate: new Date()
            });
        });
    </script>



@endsection
