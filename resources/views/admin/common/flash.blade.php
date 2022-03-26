@if (count($errors) > 0)
    <div class="alert bg-red alertdisapper">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('success'))
    <div class="alert bg-green alertdisapper">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session()->get('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert bg-red alertdisapper">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ session()->get('error') }}
    </div>
@endif

<div id="error-message" style="display:none" class="alert bg-red" data-dismiss="alert" aria-label="close">

    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
</div>
<div id="success-message" style="display:none" class="alert bg-green" data-dismiss="alert" aria-label="close">

    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
</div>
