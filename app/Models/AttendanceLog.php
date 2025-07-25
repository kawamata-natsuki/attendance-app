<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'updated_by_admin_id',
        'action_type',
        'before_clock_in',
        'after_clock_in',
        'before_clock_out',
        'after_clock_out',
        'before_breaks',
        'after_breaks',
        'before_reason',
        'after_reason',
    ];

    protected $casts = [
        'before_clock_in' => 'datetime',
        'after_clock_in' => 'datetime',
        'before_clock_out' => 'datetime',
        'after_clock_out' => 'datetime',
        'before_breaks' => 'array',
        'after_breaks' => 'array',
    ];

    // リレーション定義
    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by_admin_id');
    }
}
