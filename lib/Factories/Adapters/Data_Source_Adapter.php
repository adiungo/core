<?php

namespace Adiungo\Core\Factories\Adapters;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Interfaces\Has_Content_Model_Instance;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use Closure;
use TypeError;
use Underpin\Enums\Types;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Factories\Registry;
use Underpin\Helpers\Array_Helper;
use Underpin\Helpers\String_Helper;
use Underpin\Traits\With_Object_Cache;

class Data_Source_Adapter implements Has_Content_Model_Instance
{
    use With_Object_Cache;
    use With_Content_Model_Instance;

    /**
     * Attempts to map a column to the specified model setter.
     *
     * @param string $column The CSV column name
     * @param string $model_setter The setter function that should be called on the model.
     * @param Types|Closure $type The PHP type that the column should be set to before setting on the model, or a
     * callback that casts the type.
     * @return static
     * @throws Operation_Failed
     */
    public function map_field(string $column, string $model_setter, Types|Closure $type): static
    {
        try {
            $this->get_mappings()->add($column, ['setter' => $model_setter, 'type' => $type]);
        } catch (Operation_Failed $e) {
            $model = $this->get_content_model_instance();
            throw new Operation_Failed("Column mapping failed - The $model_setter method cannot be found on the $model model.");
        }

        return $this;
    }

    /**
     * Loads the mapping registry.
     *
     * @return Registry
     */
    public function get_mappings(): Registry
    {
        return $this->load_from_cache('mappings', fn() => new Registry(fn($key, $value) => $this->mapping_is_valid($value['setter'], $value['type'])));
    }

    /**
     * Returns true if the provided mapping is valid
     *
     * @param string $setter The setter method to call on the model
     * @param Types|Closure $type The type to set.
     * @return bool
     */
    protected function mapping_is_valid(string $setter, Types|Closure $type): bool
    {
        return method_exists($this->get_content_model_instance(), $setter);
    }

    /**
     * Converts a set of raw data into the model, using the mappings set in this class.
     *
     * @param mixed[] $raw_model
     * @return Content_Model
     * @throws Operation_Failed
     */
    public function convert_to_model(array $raw_model): Content_Model
    {
        $model = $this->get_content_model_instance();

        /** @var Content_Model $model */
        $model = new $model();

        try {
            $this->get_mappings()->each(fn(array $mapping, string $key) => $this->set_mapped_property($key, $mapping['type'], $mapping['setter'], $raw_model, $model));
        } catch (TypeError $exception) {
            throw new Operation_Failed("Could not adapt to the model.", previous: $exception);
        } catch (Item_Not_Found $exception) {
            throw new Operation_Failed("Could not adapt to the model because the mapped property was not set.", previous: $exception);
        }

        return $model;
    }

    /**
     * @param string $key
     * @param Types|Closure $type
     * @param string $setter
     * @param mixed[] $raw_model
     * @param Content_Model $model
     * @return void
     * @throws Item_Not_Found
     */
    protected function set_mapped_property(string $key, Types|Closure $type, string $setter, array $raw_model, Content_Model $model): void
    {
        if (str_contains($key, '.')) {
            $item = Array_Helper::dot($raw_model, $key);
        } elseif (isset($raw_model[$key])) {
            $item = $raw_model[$key];
        } else {
            // Bail. This key is not in the raw model.
            return;
        }

        if ($type instanceof Closure) {
            $item = $type($item);

            if (is_array($item) && empty($item)) {
                return;
            }

            $model->{$setter}(...Array_Helper::wrap($item));
        } else {
            settype($item, $type->value);
            $model->{$setter}($item);
        }
    }
}
