<form class="status-form"
      style="{{$visible}}"
      action="{{ action($action, $orderLineId)}}"
      method="POST">
    @method('PATCH')
    @Csrf
    <input type="hidden" name="status_id" value="{{$status}}">
    {{$slot}}
    <button type="submit"
            class="btn btn-{{$class}}">
        {{$buttonText}}
    </button>
</form>
