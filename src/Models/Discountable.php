<?php

namespace AscentCreative\Offer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;



class Discountable extends Pivot 
{
    use HasFactory;

    public $table = 'offer_discountables';

    public $fillable = ['id', 'offer_id', 'discountable_type', 'discountable_id'];
                                     
    public function discountable() {
        return $this->morphTo();
    }

    public function getLabelAttribute() {
        $disc = $this->discountable;

        if(method_exists($disc, 'resolveShippables')) {
            return $disc->shippable_label;
        } else {
            return $disc->shippable_label;
        }

    }

}
