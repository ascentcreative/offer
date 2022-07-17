<?php

namespace AscentCreative\Offer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;


class Discountable extends Pivot 
{
    use HasFactory;

    public $table = 'offer_discountables';

    public $fillable = [];

}
