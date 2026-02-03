<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportGenerated extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'report_format_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function reportFormat()
    {
        return $this->belongsTo(ReportFormat::class);
    }
}