<form class="status-form"
      action="{{ action($action, $orderLineId)}}"
      method="POST">
    @method('PATCH')
    @Csrf
    <input type="hidden" name="status_id" value="{{$status}}">
    {{$slot}}
    <button type="button"
            class="btn btn-{{$class}}"
            data-id="{{$orderLineId}}"
            data-status="{{$status}}">
        {{$buttonText}}
    </button>
</form>
