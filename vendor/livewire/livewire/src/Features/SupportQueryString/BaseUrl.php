<?php

namespace Livewire\Features\SupportQueryString;

use Livewire\Features\SupportAttributes\Attribute as LivewireAttribute;
use Livewire\Features\SupportFormObjects\Form;

#[\Attribute]
class BaseUrl extends LivewireAttribute
{
    public function __construct(
        public $as = null,
        public $history = false,
        public $keep = false,
        public $except = null,
    ) {}

    public function mount()
    {
        $this->setPropertyFromQueryString();
    }

    public function dehydrate($context)
    {
        if (! $context->mounting) return;

        $this->pushQueryStringEffect($context);
    }

    public function setPropertyFromQueryString()
    {
        if ($this->as === null && $this->isOnFormObjectProperty()) {
            $this->as = $this->getSubName();
        }

        $initialValue = $this->getFromUrlQueryString($this->urlName(), 'noexist');

        if ($initialValue === 'noexist') return;

        $decoded = is_array($initialValue)
            ? json_decode(json_encode($initialValue), true)
            : json_decode($initialValue, true);

        // If only part of an array is present in the query string,
        // we want to merge instead of override the value...
        if (is_array($decoded) && is_array($original = $this->getValue())) {
            $decoded = $this->recursivelyMergeArraysWithoutAppendingDuplicateValues($original, $decoded);
        }

        $value = $decoded === null ? $initialValue : $decoded;

        $this->setValue($value);
    }

    protected function recursivelyMergeArraysWithoutAppendingDuplicateValues(&$array1, &$array2)
    {
        $merged = $array1;

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->recursivelyMergeArraysWithoutAppendingDuplicateValues($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    public function pushQueryStringEffect($context)
    {
        $queryString = [
            'as' => $this->as,
            'use' => $this->history ? 'push' : 'replace',
            'alwaysShow' => $this->keep,
            'except' => $this->except,
        ];

        $context->pushEffect('url', $queryString, $this->getName());
    }

    public function isOnFormObjectProperty()
    {
        $subTarget = $this->getSubTarget();

        return $subTarget && is_subclass_of($subTarget, Form::class);
    }

    public function urlName()
    {
        return $this->as ?? $this->getName();
    }

    public function getFromUrlQueryString($name, $default = null)
    {
        if (! app('livewire')->isLivewireRequest()) {
            return request()->query($this->urlName(), $default);
        }

        // If this is a subsequent ajax request, we can't use Laravel's standard "request()->query()"...
        return $this->getFromRefererUrlQueryString(
            request()->header('Referer'),
            $name,
            $default
        );
    }

    public function getFromRefererUrlQueryString($url, $key, $default = null)
    {
        $parsedUrl = parse_url($url);
        $query = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
        }

        return $query[$key] ?? $default;
    }
}

