<?php
use Illuminate\Http\Request;

if (!function_exists('set_active')) {

    /**
     * Make the menu tag active if the request segment matches it
     *
     * @param  string $segment
     * @param  string $class
     * @return void
     */
    function set_active($segment, $class = 'active')  {
        return check_segment($segment, 2) ? $class : '';
    }

}

if (!function_exists('check_segment')) {

    /**
     * Check if the request segment is equal to the name
     *
     * @param  string $name
     * @param  int $part
     * @return bool
     */
    function check_segment($name, $part = 1) {
        return get_segment($part) == $name;
    }
}

if (!function_exists('get_segment')) {

    /**
     * Get the segment with the part number
     *
     * @param  int $part
     * @return string
     */
    function get_segment($part) {
        $request = Request();

        return $request->segment($part);
    }
}

if (! function_exists('get_count')) {

    /**
     * Get the count of records in the table
     *
     * @param  string $table
     * @return int
     */
    function get_count($table) {
        return DB::table($table)->get()->count();
    }
}

if (!function_exists('get_request')) {

    /**
     * Get the request validation class if exists otherwise get the Request class
     *
     * @param  mixed $request
     * @return \Request
     */
    function get_request($request)
    {
        return is_object($request) ? $request : \Request();
    }
}
