<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BookingForm extends Model
{
    use SoftDeletes;
    protected $table = 'booking_forms';
    protected $fillable = [
        'reservation_date', 'reservation_time', 'name_surname', 'phone', 'country', 'massage_package', 'hammam_package', 'male_pax', 'female_pax', 'form_status_id', 'answered_time'
    ];
    public function status()
    {
        return $this->belongsTo(FormStatuses::class, 'form_status_id');
    }
}
