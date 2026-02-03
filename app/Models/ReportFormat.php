<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFormat extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function reportGenerateds()
    {
        return $this->hasMany(ReportGenerated::class);
    }
}