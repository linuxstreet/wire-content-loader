@props(['layout' => null])

<div x-data="{
    id: @entangle('id'),
    isLoading: @entangle('isLoading'),
    hideContentWhileLoading: true,
    spinnerClass: '',

    handle(e) {
        let p = e.detail[0];

        if (p.spinner !== undefined || p.spinner === false) { return; }
        if (p.target === undefined) { p.target = this.id; }
        if (p.target !== this.id) { return; }
        if (p.hideWhileLoading !== undefined) { this.hideContentWhileLoading = p.hideWhileLoading; }

        this.spinnerClass = p.spinnerClass ?? '';
        this.isLoading = true;
        },
    showWhileLoading() {
        return (this.hideContentWhileLoading) ? !this.isLoading : true;
        }
    }"
     x-on:content-load.window="handle($event)">

    <x-wire-content-loader::loading-spinner x-cloak x-show="isLoading"/>

    @if ($this->readyToRender())
        <div x-show="showWhileLoading()">{!! $this->content !!}</div>
    @endif
</div>
