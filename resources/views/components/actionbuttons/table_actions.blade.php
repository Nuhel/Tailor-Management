<div>

    {!! $extraButton??"" !!}
    <a href="{{route($route.'.show', [$param=> $value] )}}" class="btn btn-outline-primary btn-sm mr-2">
        <i class="fa fa-eye" aria-hidden="true">
            View
        </i>
    </a>


    <a href="{{route($route.'.edit', [$param=> $value] )}}"
        class="btn btn-outline-primary btn-sm mr-2">
        <i class="fa fa-edit" aria-hidden="true">
        Edit
        </i>
    </a>
    <form action="{{route($route.'.destroy', [$param=> $value] )}}" method="post" class="d-inline-block">
        @method('delete')
        @csrf
        <button type="submit"
            class="btn btn-outline-danger btn-sm mr-2">
        <i class="fa fa-trash" aria-hidden="true">
        Delete
        </i>
        </button>
    </form>
</div>
