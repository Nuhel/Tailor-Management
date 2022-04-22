<div class="table-action-wrapper">

    {!! $extraButton??"" !!}
    <a href="{{route($route.'.show', [$param=> $value] )}}" class="btn btn-outline-primary btn-sm">
        <i class="fa fa-eye" aria-hidden="true">

        </i>
    </a>


    <a href="{{route($route.'.edit', [$param=> $value] )}}"
        class="btn btn-outline-primary btn-sm">
        <i class="fa fa-edit" aria-hidden="true">

        </i>
    </a>
    <form action="{{route($route.'.destroy', [$param=> $value] )}}" method="post" class="d-inline-block">
        @method('delete')
        @csrf
        <button type="submit"
            class="btn btn-outline-danger btn-sm w-100">
        <i class="fa fa-trash" aria-hidden="true">

        </i>
        </button>
    </form>
</div>
