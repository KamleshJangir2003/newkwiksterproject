<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientForm extends Model
{
    protected $table = 'client_form';
    protected $fillable = [
        'user_id',
        'customer_id',
        'upload_date',
        'india_agent_name',
        'customer_name',
        'phone',
        'company_name',
        'pdf',
        'status',
        'step',
        'step_value',
        'priority',
        'pipeline_reminder',
        'sold_amount',
        'lost_reason',
        'cancel_reason',
        'estimate_closing_date',
        'estimate_closing_amount',
        'estimate_closing_probability',
        'approved_declined',
    ];
    use HasFactory;
}
