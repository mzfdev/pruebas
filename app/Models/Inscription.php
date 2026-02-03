<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'inscription_status_id',
        'qualification',
        'coursed_times',
    ];

    protected $casts = [
        'qualification' => 'decimal:2',
        'coursed_times' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function inscriptionStatus()
    {
        return $this->belongsTo(InscriptionStatus::class);
    }

    public function reportInscriptions()
    {
        return $this->hasMany(ReportInscription::class);
    }
}