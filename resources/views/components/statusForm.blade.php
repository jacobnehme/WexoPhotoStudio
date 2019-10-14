<form class="form"
    action="{{ action($action, $photoLineId)}}"
    method="POST">
    @method('PATCH')
    @Csrf
    <label for="status-{{$photoLineId}}"
           class="btn btn-{{$class}}">
        {{$buttonText}}
        <input type="checkbox" name="status"
               id="status-{{$photoLineId}}"
               onchange="this.form.submit()"
               {{$isChecked}}
               style="display: none">
    </label>
</form>
