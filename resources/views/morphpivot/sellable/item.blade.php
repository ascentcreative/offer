@extends('forms::components.fields.morphpivot.item')

@section('item-content')

    {{ $item->sellable->sellable_label }}

@overwrite