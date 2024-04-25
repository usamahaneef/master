<?php
namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

trait HasSchemalessProperties
{
    use SchemalessAttributesTrait;
    protected $schemalessAttributes = [
        'properties'
    ];

    public function scopeWithProperties():Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('properties');
    }
}