<?php

namespace Adiungo\Core\Traits;

namespace Adiungo\Core\Traits;

use Adiungo\Core\Collections\Attachment_Collection;
use Adiungo\Core\Abstracts\Attachment;
use Underpin\Exceptions\Operation_Failed;

trait With_Attachments
{
    protected Attachment_Collection $attachments;

    /**
     * Sets the attachments
     *
     * @param Attachment $attachment
     * @param Attachment ...$attachments The attachments to set.
     * @return $this
     * @throws Operation_Failed
     */
    public function add_attachments(Attachment $attachment, Attachment ...$attachments): static
    {
        $attachments = func_get_args();

        /** @var Attachment $attachment_item */
        foreach ($attachments as $attachment_item) {
            $this->get_attachments()->add((string)$attachment_item->get_id(), $attachment_item);
        }

        return $this;
    }

    /**
     * Gets the attachments
     *
     * @return Attachment_Collection
     */
    public function get_attachments(): Attachment_Collection
    {
        if (!isset($this->attachments)) {
            $this->attachments = new Attachment_Collection();
        }

        return $this->attachments;
    }

    /**
     * @param string $id
     * @param string ...$ids
     * @return static
     * @throws Operation_Failed
     */
    public function remove_attachments(string $id, string ...$ids): static
    {
        $all_ids = func_get_args();

        /** @var Attachment_Collection $result */
        $result = $this->get_attachments()->query()->not_in('id', ...$all_ids)->get_results();

        $this->attachments = $result;
        return $this;
    }

    /**
     * Returns true if this class has any attachments.
     *
     * @return bool
     */
    public function has_attachments(): bool
    {
        return !empty($this->get_attachments()->to_array());
    }
}
