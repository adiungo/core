<?php

namespace Adiungo\Core\Tests\Integration\Mocks;

use Adiungo\Core\Abstracts\Content_Model;
use Adiungo\Core\Interfaces\Has_Content;
use Adiungo\Core\Interfaces\Has_Name;
use Adiungo\Core\Traits\With_Content;
use Adiungo\Core\Traits\With_Name;
use Underpin\Interfaces\Identifiable_Int;
use Underpin\Traits\With_Int_Identity;

final class Test_Model extends Content_Model implements Has_Name, Has_Content, Identifiable_Int
{
    use With_Content;
    use With_Name;
    use With_Int_Identity;
}
