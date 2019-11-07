<form id="status-form-{{$orderLineId}}"
      class="form"
      style="{{$visible}}"
      action="{{ action($action, $orderLineId)}}"
      method="POST">
    @method('PATCH')
    @Csrf
    <label for="status-{{$orderLineId}}"
           class="btn btn-{{$class}}">
        {{$buttonText}}
        <input type="checkbox" name="status"
               id="status-{{$orderLineId}}"
               onchange="this.form.submit()"
               {{$isChecked}}
               style="display: none">
    </label>
</form>
