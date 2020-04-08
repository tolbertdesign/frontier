<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CcTransactionAction extends Model
{
    public $timestamps = false;

    public function ccTransaction()
    {
        return $this->belongsTo(CcTransaction::class);
    }

    public function populateCcTransactionAction($transaction, $status)
    {
        $this->cc_transaction_id = $transaction->id;
        $this->status = $status;
        $this->order_time = Carbon::now();
    }
}
