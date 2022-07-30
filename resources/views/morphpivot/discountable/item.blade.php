@extends('forms::components.fields.morphpivot.item')

@section('item-content')

    {{ $item->discountable->sellable_label }}

@overwrite