<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropPrediction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'crop_predictions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'nitrogen',
        'phosphorus',
        'potassium',
        'temperature',
        'humidity',
        'ph',
        'rainfall',
        'recommended_crop',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'nitrogen'    => 'float',
        'phosphorus'  => 'float',
        'potassium'   => 'float',
        'temperature' => 'float',
        'humidity'    => 'float',
        'ph'          => 'float',
        'rainfall'    => 'float',
    ];

    /**
     * Relasi: prediksi milik seorang user.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
