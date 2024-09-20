<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;

class DeletedModel extends \Spatie\DeletedModels\Models\DeletedModel
{
    use Userstamps;
}
