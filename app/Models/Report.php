<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_status_id',
        'description',
    ];

    public function reportStatus()
    {
        return $this->belongsTo(ReportStatus::class);
    }

    public function reportInscriptions()
    {
        return $this->hasMany(ReportInscription::class);
    }

    public function reportGenerateds()
    {
        return $this->hasMany(ReportGenerated::class);
    }
}