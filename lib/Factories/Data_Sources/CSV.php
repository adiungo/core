<?php

namespace Adiungo\Core\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Content_Model_Instance;
use Adiungo\Core\Interfaces\Has_Limit;
use Adiungo\Core\Interfaces\Has_Offset;
use Adiungo\Core\Traits\With_Content_Model_Instance;
use Adiungo\Core\Traits\With_Limit;
use Adiungo\Core\Traits\With_Offset;
use ParseCsv\Csv as CSV_Lib;
use TypeError;
use Underpin\Enums\Types;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Exceptions\Unknown_Registry_Item;
use Underpin\Factories\Registry;
use Underpin\Helpers\Array_Helper;
use Underpin\Traits\With_Object_Cache;

class CSV implements Data_Source, Has_Content_Model_Instance, Has_Offset, Has_Limit
{
    use With_Content_Model_Instance;
    use With_Offset;
    use With_Limit;
    use With_Object_Cache;

    /**
     * Source CSV String
     *
     * @var string
     */
    protected string $csv;

    /**
     * Attempts to map a column to the specified model setter.
     *
     * @param string $column The CSV column name
     * @param string $model_setter The setter function that should be called on the model.
     * @param Types $type The PHP type that the column should be set to before setting on the model.
     * @return static
     * @throws Operation_Failed
     */
    public function map_column(string $column, string $model_setter, Types $type): static
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
    protected function get_mappings(): Registry
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
     * Sets the raw CSV string to use in this data source.
     *
     * @param string $csv
     * @return $this
     */
    public function set_csv(string $csv): static
    {
        $this->csv = $csv;

        return $this;
    }

    /**
     * Fetches the data from the CSV file.
     *
     * @throws Operation_Failed
     */
    public function get_data(): Content_Model_Collection
    {
        $csv = $this->get_csv_instance();
        $csv->parse($this->csv, $this->get_offset(), $this->get_limit());

        return (new Content_Model_Collection())->seed(Array_Helper::map($csv->data, fn(array $datum) => $this->convert_to_model($datum)));
    }

    /**
     * Creates a CSV instance, if it is not already created.
     *
     * @return CSV_Lib
     */
    protected function get_csv_instance(): CSV_Lib
    {
        return $this->load_from_cache('csv_instance', fn() => new CSV_Lib());
    }

    /**
     * Converts a set of raw data into the model, using the mappings set in this class.
     *
     * @param string[] $raw_model
     * @return Content_Model
     * @throws Operation_Failed
     */
    protected function convert_to_model(array $raw_model): Content_Model
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

    public function has_more(): bool
    {
        $this->get_csv_instance()->loadDataString($this->csv);
        return $this->get_csv_instance()->getTotalDataRowCount() > $this->get_offset();
    }

    public function get_next(): Data_Source
    {
        return (clone $this)->set_offset($this->get_offset() + $this->get_limit());
    }

    /**
     * Gets a single item from the source.
     *
     * @param int|string $id
     * @return Content_Model
     * @throws Item_Not_Found
     * @throws Operation_Failed
     */
    public function get_item(int|string $id): Content_Model
    {
        $column = array_keys($this->get_mappings()->filter(fn(array $item) => $item['setter'] === 'set_id')->to_array());
        if (empty($column)) {
            throw new Item_Not_Found("Could not find ID column in adapter. Did you remember to set the column mapping with get_id?");
        }

        $csv = $this->get_csv_instance();
        $csv->parse(dataString: $this->csv, conditions: $column[0] . ' = ' . $id);

        if (empty($csv->data)) {
            throw new Item_Not_Found("No item with that ID exists in this file.");
        }

        return $this->convert_to_model($csv->data[0]);
    }
}
