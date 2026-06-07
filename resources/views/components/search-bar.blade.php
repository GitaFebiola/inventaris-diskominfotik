<form
    method="GET"
    action="{{ $action }}"
    id="searchForm">

    <div class="input-group mb-3">

        <input
            type="text"
            name="search"
            id="searchInput"
            class="form-control"
            placeholder="{{ $placeholder }}"
            value="{{ request('search') }}">

        @if(request('search'))

            <a href="{{ $action }}"
               class="btn btn-secondary">

                Reset

            </a>

        @endif

    </div>

</form>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function()
    {
        let timer;

        const input =
            document.getElementById(
                'searchInput'
            );

        const form =
            document.getElementById(
                'searchForm'
            );

        input.addEventListener(
            'keyup',
            function()
            {
                clearTimeout(timer);

                timer = setTimeout(
                    function()
                    {
                        form.submit();
                    },
                    500
                );
            }
        );
    }
);

</script>