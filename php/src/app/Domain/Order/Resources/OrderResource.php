<?php

namespace App\Domain\Order\Resources;

use App\Domain\Resource;

class OrderResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ordNo' => $this->ord_no,
            'productName' => $this->product_name,
            'paymentTime' => $this->paid_at->format('Y-m-d H:i:s'),
            'orderTime' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
