<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}