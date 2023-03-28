<?php

namespace Adiungo\Core\Factories\Data_Sources;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Collections\Content_Model_Collection;
use Adiungo\Core\Interfaces\Data_Source;
use Adiungo\Core\Interfaces\Has_Data_Source_Adapter;
use Adiungo\Core\Interfaces\Has_Limit;
use Adiungo\Core\Interfaces\Has_Offset;
use Adiungo\Core\Traits\With_Data_Source_Adapter;
use Adiungo\Core\Traits\With_Limit;
use Adiungo\Core\Traits\With_Offset;
use ParseCsv\Csv as CSV_Lib;
use Underpin\Exceptions\Item_Not_Found;
use Underpin\Exceptions\Operation_Failed;
use Underpin\Helpers\Array_Helper;
use Underpin\Traits\With_Cache;

class CSV implements Data_Source, Has_Offset, Has_Limit, Has_Data_Source_Adapter
{
    use With_Offset;
    use With_Limit;
    use With_Cache;
    use With_Data_Source_Adapter;

    /**
     * Source CSV String
     *
     * @var string
     */
    protected string $csv;

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

        return (new Content_Model_Collection())->seed(Array_Helper::map($csv->data, fn (array $datum) => $this->get_data_source_adapter()->convert_to_model($datum)));
    }

    /**
     * Creates a CSV instance, if it is not already created.
     *
     * @return CSV_Lib
     */
    protected function get_csv_instance(): CSV_Lib
    {
        return $this->load_from_cache('csv_instance', fn () => new CSV_Lib());
    }

    /**
     * @inheritDoc
     */
    public function has_more(): bool
    {
        $this->get_csv_instance()->loadDataString($this->csv);
        return $this->get_csv_instance()->getTotalDataRowCount() > $this->get_offset();
    }

    /**
     * @inheritDoc
     */
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
        $column = array_keys($this->get_data_source_adapter()->get_mappings()->filter(fn (array $item) => $item['setter'] === 'set_id')->to_array());
        if (empty($column)) {
            throw new Item_Not_Found("Could not find ID column in adapter. Did you remember to set the column mapping with get_id?");
        }

        $csv = $this->get_csv_instance();
        $csv->parse(dataString: $this->csv, conditions: $column[0] . ' = ' . $id);

        if (empty($csv->data)) {
            throw new Item_Not_Found("No item with that ID exists in this file.");
        }

        return $this->get_data_source_adapter()->convert_to_model($csv->data[0]);
    }
}
