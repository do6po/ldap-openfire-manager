<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 18.02.2018
 * Time: 2:59
 */

/** @var \Illuminate\Support\MessageBag $errors */
/** @var string $input */
/** @var string $attribute */
/** @var string $label */
?>

<div class="{{ $class ?? '' }} {{ $errors->has($attribute) ? 'has-error' : '' }}">
    @if(isset($label))
        <strong>
            <label for="{{ $attribute }}">{{ $label ?? '' }}</label>
        </strong>
    @endif
    {!! $input !!}
    @if ($errors->has($attribute))
        <div class="help-block">{{ $errors->first($attribute) }}</div>
    @endif
</div>
