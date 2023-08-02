<?php

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{

    public function layout(string $layout, array $data): static;

    public function layoutData(array $data): static;
}
