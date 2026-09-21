<?php

declare(strict_types=1);

namespace App\Livewire\User\Profile;

use Exception;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Traits\Alert;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;

class Information extends Component
{
    use Alert;

    public User $user;

    #[On('mount')]
    public function mount(): void
    {
        $this->user = user();
        $this->user->theme ??= config('app.theme');
        $this->user->font ??= config('app.font');
    }

    /**
     * @return array<int, array{label: string, value: string}>
     */
    #[Computed]
    public function themes(): array
    {
        return collect(config('app.themes'))
            ->map(fn (string $theme) => ['label' => __('profile.themes.'.$theme), 'value' => $theme])
            ->all();
    }

    /**
     * @return array<int, array{label: string, value: string}>
     */
    #[Computed]
    public function fonts(): array
    {
        return collect(config('app.fonts'))
            ->map(fn (string $font) => ['label' => str($font)->headline()->toString(), 'value' => $font])
            ->all();
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    #[Computed]
    public function roles()
    {
        return $this->user->getRoleNames();
    }

    public function rules(): array
    {
        return [
            'user.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($this->user->id),
            ],
            'user.first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'user.last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'user.theme' => [
                'required',
                Rule::in(config('app.themes')),
            ],
            'user.font' => [
                'required',
                Rule::in(config('app.fonts')),
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.user.profile.information');
    }

    public function save(): void
    {
        $this->validate();

        try {
            $this->user->save();

            $this->dispatch('updated', name: $this->user->name, theme: $this->user->theme, font: $this->user->font);
            $this->success();

            return;
        } catch (Exception $e) {
            report($e);
        }

        $this->error();
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'user.name'       => __('profile.attributes.name'),
            'user.first_name' => __('profile.attributes.first_name'),
            'user.last_name'  => __('profile.attributes.last_name'),
            'user.theme'      => __('profile.attributes.theme'),
            'user.font'       => __('profile.attributes.font'),
        ];
    }
}
