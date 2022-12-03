<?php

namespace Adiungo\Core\Factories\Adapters;


use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Interfaces\Has_Content_Model_Instance;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use TypeError;
use Underpin\Enums\Types;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Factories\Registry;
use Underpin\Helpers\Array_Helper;
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
     * @param Types $type The PHP type that the column should be set to before setting on the model.
     * @return static
     * @throws Operation_Failed
     */
    public function map_field(string $column, string $model_setter, Types $type): static
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
     * @param Types $type The type to set.
     * @return bool
     */
    protected function mapping_is_valid(string $setter, Types $type): bool
    {
        return method_exists($this->get_content_model_instance(), $setter) && $type instanceof Types;
    }

    /**
     * Converts a set of raw data into the model, using the mappings set in this class.
     *
     * @param string[] $raw_model
     * @return Content_Model
     * @throws Operation_Failed
     */
    public function convert_to_model(array $raw_model): Content_Model
    {
        $model = $this->get_content_model_instance();

        /** @var Content_Model $model */
        $model = new $model();

        try {
            Array_Helper::each($raw_model, fn(mixed $item, string $key) => $this->set_mapped_property($key, $item, $model));
        } catch (TypeError $exception) {
            throw new Operation_Failed("Could not adapt CSV to the model.", previous: $exception);
        } catch (Unknown_Registry_Item $exception) {
            throw new Operation_Failed("Could not adapt CSV to the model because the mapped property was not set.", previous: $exception);
        }

        return $model;
    }

    /**
     * @param string $key
     * @param mixed $item
     * @param Content_Model $model
     * @return void
     * @throws Unknown_Registry_Item
     */
    protected function set_mapped_property(string $key, mixed $item, Content_Model $model): void
    {
        /** @var array{type:Types, setter:string} $mapping */
        $mapping = $this->get_mappings()->get($key);

        settype($item, $mapping['type']->value);

        $model->{$mapping['setter']}($item);
    }
}