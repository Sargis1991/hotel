<div class="form-group">
    <label for="number">Room Number</label>
    <input type="number" name="number" min='1' class="form-control" id="number"
           placeholder="Enter room number" value="{{old('number') ?? $room->number}}">
    @if ($errors->has('number'))
        <small id="emailHelp" class="form-text text-danger">{{$errors->first('number')}}</small>
    @endif

</div>

<button type="submit" class="btn btn-success m-lg-3 float-end">Save</button>
<a href="{{route('home')}}" class="btn btn-danger mt-3 float-end">Cancel</a>
