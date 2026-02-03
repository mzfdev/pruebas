<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportInscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'inscription_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}