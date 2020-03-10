<?php

namespace DamianLewis\October\Pivot\Traits;

trait PivotEventTrait
{
    use ExtendBelongsToManyTrait;
    use ExtendFireModelEventTrait;

    public static function pivotAttaching($callback, $priority = 0)
    {
        static::registerModelEvent('pivotAttaching', $callback, $priority);
    }

    public static function pivotAttached($callback, $priority = 0)
    {
        static::registerModelEvent('pivotAttached', $callback, $priority);
    }

    public static function pivotDetaching($callback, $priority = 0)
    {
        static::registerModelEvent('pivotDetaching', $callback, $priority);
    }

    public static function pivotDetached($callback, $priority = 0)
    {
        static::registerModelEvent('pivotDetached', $callback, $priority);
    }

    public static function pivotUpdating($callback, $priority = 0)
    {
        static::registerModelEvent('pivotUpdating', $callback, $priority);
    }

    public static function pivotUpdated($callback, $priority = 0)
    {
        static::registerModelEvent('pivotUpdated', $callback, $priority);
    }

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents()
    {
        return array_merge(
            [
                'creating',
                'created',
                'updating',
                'updated',
                'deleting',
                'deleted',
                'saving',
                'saved',
                'restoring',
                'restored',
                'pivotAttaching',
                'pivotAttached',
                'pivotDetaching',
                'pivotDetached',
                'pivotUpdating',
                'pivotUpdated',
            ],
            $this->observables
        );
    }
    
    public static function boot()
    {
        parent::boot();

        static::pivotAttaching(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if (method_exists($model, 'beforeAttach')) {
                $model->beforeAttach($relationName, $pivotIds, $pivotIdsAttributes);
            }
        });

        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if (method_exists($model, 'afterAttach')) {
                $model->afterAttach($relationName, $pivotIds, $pivotIdsAttributes);
            }
        });

        static::pivotDetaching(function ($model, $relationName, $pivotIds) {
            if (method_exists($model, 'beforeDetach')) {
                $model->beforeDetach($relationName, $pivotIds);
            }
        });

        static::pivotDetached(function ($model, $relationName, $pivotIds) {
            if (method_exists($model, 'afterDetach')) {
                $model->afterDetach($relationName, $pivotIds);
            }
        });

        static::pivotUpdating(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if (method_exists($model, 'beforePivotUpdate')) {
                $model->beforePivotUpdate($relationName, $pivotIds, $pivotIdsAttributes);
            }
        });

        static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if (method_exists($model, 'afterPivotUpdate')) {
                $model->afterPivotUpdate($relationName, $pivotIds, $pivotIdsAttributes);
            }
        });
    }
}
