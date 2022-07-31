<?php

namespace AscentCreative\Offer\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;


class Sellable extends Pivot 
{
    use HasFactory;

    public $table = 'offer_sellables';

    public $fillable = ['id', 'offer_id', 'sellable_type', 'sellable_id'];
                                     
    public function sellable() {
        return $this->morphTo();
    }

    // public function getLabelAttribute() {
    //     $disc = $this->discountable;

    //     if(method_exists($disc, 'resolveShippables')) {
    //         return $disc->shippable_label;
    //     } else {
    //         return $disc->shippable_label;
    //     }

    // }

}
