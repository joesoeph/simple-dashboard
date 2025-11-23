@if ($message)
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        <strong>{{ ucfirst($type) }}!</strong> {{ $message }}

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <script>
        setTimeout(() => {
            $('.alert').hide().remove();
        }, 5000);
    </script>
@endif
