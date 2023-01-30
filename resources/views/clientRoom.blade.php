
<div class="col-md-3">
    <div>
        @if($room->status === 0)
        <form method="POST" action="{{route('reserve',$room->id)}}">
            @csrf
            <div>
                <input name="date" class="datepicker" data-date-format="d/m/Y">
            </div>
            <button type="submit"  class="btn btn-warning m-lg-2">Reserve</button>
        </form>
        @else
            <form method="POST" action="{{route('change',$room->id)}}">
                @csrf
                @method('PUT')
                <div>
                    <input name="date" class="datepicker" value=" {{ \Carbon\Carbon::parse($room->user()->first()->pivot->day)->format('m/d/Y')}}" >
                </div>
                <button type="submit"  class="btn btn-primary m-lg-2">Change</button>
            </form>
        @endif
    </div>
    <div class="roomItem {{$room->status === 0 ? 'bg-success' :'bg-danger'}}">
        @if($room->status === 1)
            <div> <a href="{{route('cancel',$room->id)}}" class="btn btn-secondary m-lg-2">Cancel</a></div>
            @endif

        <div class="number">{{$room->number}}</div>

    </div>

</div>

