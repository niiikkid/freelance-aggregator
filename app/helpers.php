<?php
if (! function_exists('make')) {
    /**
     * @template T
     * @param T $abstract
     * @return T
     */
    function make($abstract, array $parameters = [])
    {
        return app()->make($abstract, $parameters);
    }
}
