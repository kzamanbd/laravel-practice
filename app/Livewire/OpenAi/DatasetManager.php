<?php

namespace App\Livewire\OpenAi;

use App\Models\Dataset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use OpenAI\Laravel\Facades\OpenAI;

class DatasetManager extends Component
{
    use WithFileUploads;

    public $datasets;

    public bool $showModal = false;

    #[Validate('required|file|extensions:pdf,docx,txt,doc')]
    public $file;

    public function mount()
    {
        $this->datasets = Dataset::latest()->get();
    }

    public function uploadFile()
    {
        $this->validate();

        $path = $this->file->store('datasets');

        $text = $this->getTextContent($path);

        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-3-small',
            'input' => $text,
        ]);

        $embedding = Arr::get($response->embeddings[0]->toArray(), 'embedding');

        $dataset = Dataset::create([
            'title' => $this->file->getClientOriginalName(),
            'path' => $path,
            'text' => $text,
            'embedding' => $embedding,
        ]);

        // push the new dataset to datasets
        $this->datasets->prepend($dataset);

        $this->showModal = false;
    }

    protected function getTextContent($path): ?string
    {
        $file = Storage::path($path);

        if (file_exists($file)) {
            $content = file_get_contents($file);

            // utf8 encode the content
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

            return $content;
        }

        return null;
    }

    public function render()
    {
        return view('livewire.open-ai.dataset-manager');
    }
}