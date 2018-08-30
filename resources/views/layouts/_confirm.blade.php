<div class="modal fade" id="{{ $id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            {!! Form::open([
                'id' => $id . '-form',
                 'route' => $route
             ]) !!}
            <div class="modal-body">
                <h5 class="text-center pb-3">
                    {{ $message }}
                </h5>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {!! Form::submit($buttonName, [
                        'class' => $buttonClass,
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>