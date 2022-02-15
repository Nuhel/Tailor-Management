<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    {!!Form::input()->setName('name')->setValue()->setLabel()->setPlaceholder()->render()!!}
    <div class="form-group text-center">
        <button type="submit" class="btn btn-success mt-3" name="submit">Submit</button>
    </div>
</form>
