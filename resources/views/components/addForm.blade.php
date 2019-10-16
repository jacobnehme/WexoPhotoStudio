<form class="form"
    action="{{action('PhotoLineController@store')}}"
    method="POST">
    @Csrf
    <input type="hidden" name="orderLine_id"
           value="{{$orderLineId}}">
    <input type="hidden" name="photo_id"
           value="{{$photoId}}">
    {{--TODO approved by default--}}
    <button type="submit" class="btn btn-primary">
        Pre-approve
    </button>
</form>
