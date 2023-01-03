<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Abstracts\Attachment;
use Adiungo\Core\Collections\Attachment_Collection;
use Underpin\Exceptions\Operation_Failed;

interface Has_Attachments
{
    /**
     * Gets the attachment
     *
     * @return Attachment_Collection
     */
    public function get_attachments(): Attachment_Collection;

    /**
     * Sets the attachment
     *
     * @param Attachment $attachment The attachment to set.
     * @param Attachment ...$attachments
     * @return static
     * @throws Operation_Failed
     */
    public function add_attachments(Attachment $attachment, Attachment ...$attachments): static;

    /**
     * @param string $id
     * @param string ...$ids
     * @return static
     * @throws Operation_Failed
     */
    public function remove_attachments(string $id, string ...$ids): static;

    /**
     * Returns true if there are any attachments.
     *
     * @return bool
     */
    public function has_attachments(): bool;
}
