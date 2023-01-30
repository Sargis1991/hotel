
<div class="col-md-2">
        <div class="d-flex">
            <a href="{{route('rooms.edit',$room->id)}}" class="btn btn-outline-warning">Edit</a>
            <form method="POST" action="{{route('rooms.destroy',$room->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>

        </div>
    <div class="roomItem">
       <div class="number">{{$room->number}}</div>
    </div>
</div>
