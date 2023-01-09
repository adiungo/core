<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Collections\Attachment_Collection;

interface Can_Convert_To_Attachment_Collection
{
    public function to_attachment_collection(): Attachment_Collection;
}
