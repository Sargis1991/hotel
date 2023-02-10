
<div class="col-md-3" style="border: 1px solid;padding: 5px">
    <div>
        <form method="POST" action="{{route('reserve',$room->id)}}">
            @csrf
            <div>
                <input name="from" class="datepicker" data-date-format="d/m/Y" placeholder="from" >
            </div>
            <div class="mt-2">
                <input name="to" class="datepicker" data-date-format="d/m/Y" placeholder="to" >
            </div>
            <button type="submit"  class="btn btn-warning m-lg-2">Reserve</button>
        </form>

    </div>
    <div class="mb-2">
        Reserved days
        @forelse($room->user()->get() as $item )
            <ul class="list-group">
                <li class="list-group-item">
                    <div>
                        From: {{\Carbon\Carbon::parse($item->pivot->from)->format('m/d/Y')}}
                        To : {{  \Carbon\Carbon::parse($item->pivot->to)->format('m/d/Y')}}
                    </div>
                </li>
        @empty
            All Days Free
        @endforelse
    </div>
    <div class="roomItem ">

        <div > Room number {{$room->number}}</div>

    </div>

</div>



