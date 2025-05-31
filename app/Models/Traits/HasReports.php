<?php

namespace App\Models\Traits;

use App\Enums\Report\ReportStatus;
use App\Enums\Report\ReportType;
use App\Models\Report;
use App\Models\User;

trait HasReports
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see Report}s that belong to this model.
     *
     * @return MorphMany<Report>
     */
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Records a new {@see Report} belonging to this model.
     *
     * @param  User  $reporter  The user who is performing the report.
     * @param  ReportType  $type  The type of the report.
     * @param  string  $report  The actual text of the report.
     * @param  string|null  $title  The title of the report. Optional.
     * @return Report The newly created report.
     */
    public function recordReport(
        User $reporter,
        ReportType $type,
        string $report,
        ?string $title = null,
    ) {
        return $this->reports()->create([
            'reported_by' => $reporter->id,
            'type' => $type,
            'title' => $title,
            'report' => $report,
            'status' => ReportStatus::PENDING,
        ]);
    }
}
