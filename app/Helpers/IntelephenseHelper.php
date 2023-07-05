<?php

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
    /**
     * @return $this
     */
    public function layout(string $layout, array $data): static;

    /**
     * @return $this
     */
    public function layoutData(array $data): static;
}
