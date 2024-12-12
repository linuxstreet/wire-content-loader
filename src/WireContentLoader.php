<?php

namespace Linuxstreet\WireContentLoader;

use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use Livewire\Component;

class WireContentLoader extends Component
{
    /**
     * @const Default component ID
     */
    private const ID = 'main';
    public string $content = '';
    public string $component = '';
    public string $view = '';
    public array $params = [];
    public string $id = 'main';
    public bool $isLoading = false;
    public bool $forceReload = false;

    /**
     * When forceReload is set to true we need to
     * generate a random ID for the component,
     * so Livewire can re-render the content
     */
    private function generateKey(): string
    {
        if (!$this->forceReload) {
            return $this->component;
        }

        $parts[] = $this->component;
        $parts[] = microtime();

        return implode('-', $parts);
    }

    public function mount($id = null): void
    {
        $this->id = $id ?? self::ID;
    }

    #[On('content-load')]
    public function prepare($options): void
    {
        $component = $options['component'] ?? '';
        $view = $options['view'] ?? '';
        throw_if((blank($component) && blank($view)), new \Exception('Component or View name must be provided.'));

        $target = $options['target'] ?? 'main';

        if ($target !== $this->id) {
            $this->skipRender();
            $this->isLoading = false;

            return;
        }

        $this->component = $component;
        $this->view = $view;
        $this->params = $options['params'] ?? [];
        $this->forceReload = $options['forceReload'] ?? false;
    }

    public function readyToRender(): bool
    {
        return (!blank($this->component . $this->view));
    }

    public function render()
    {
        if ($this->readyToRender()) {
            try {
                $this->content = (!$this->view)
                    ? Blade::render('@livewire($component, $params, key($key))', ['component' => $this->component,
                        'params' => $this->params, 'key' => $this->generateKey()])
                    : Blade::render('@include($component, $params)', ['component' => $this->view, 'params' => $this->params]);
            } catch (\Throwable $e) {
                $this->content = $e->getMessage();
            }

            $this->isLoading = false;
        }

        return view('wire-content-loader::livewire.content-loader');
    }
}
