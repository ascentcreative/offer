<?php

namespace AscentCreative\Offer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Support\Facades\DB;



/**
 * Represents an offer in the system (which is processed by a Rule)
 */
class OfferUse extends MorphPivot 
{
    use HasFactory;

    public $table = 'offer_usage';

    // public $fillable = [''];


    public $casts = [
        'reset_data'=>'array',
    ];



}
