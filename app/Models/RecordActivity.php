<?php

namespace App\Models;
use Illuminate\Support\Arr;

trait RecordActivity{
    public $oldAtributes = [];

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->oldAtributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }
    
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public static function bootRecordActivity()
    {
        foreach(self::recordableEvents() as $event):
            static::$event(function($model) use ($event){
                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated'){
                static::updating(function($model){
                    $model->oldAtributes = $model->getOriginal();
                });
            }
        endforeach;
    }

    protected static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ['created', 'updated', 'deleted'];
    }

    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }
}

?>