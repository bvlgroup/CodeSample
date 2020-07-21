@if (session()->has('flash_message'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fa fa-fw fa-check"></i> {{ session()->get('flash_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>

    </div>
@endif
@if (session()->has('flash_info'))
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fa fa-fw fa-check"></i> {{ session()->get('flash_info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
@if (!empty($errors) && is_countable($errors) && count($errors) > 0)
    <div class="alert alert-danger alert-notification">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
<div class="alert alert-success alert-notification">
    {{ session('status') }}
</div>
@elseif(session('error'))
<div class="alert alert-danger alert-notification">
    {{ session('error') }}
</div>
@endif  