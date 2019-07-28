<?php

if (! function_exists('success_message')) {

    /**
     * Return Success Message Response
     *
     * @param  mixed $data
     * @return void
     */
    function success_message($data = '')
    {
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }
}

if (! function_exists('error_message')) {

    /**
     * Return Error Message Response
     *
     * @param  mixed $data
     * @param  int $code
     * @return void
     */
    function error_message($data = '', $code = 403)
    {
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], $code);
    }
}

if (! function_exists('can_not_access')) {

    /**
     * Return the can not access this page response
     *
     * @return \Response
     */
    function can_not_access() {
        return response()->json([
            'message' => 'Can not Access this Page',
            'type' => 'error'
        ], 403);
    }
}

if (! function_exists('create_success')) {

    /**
     * Return created successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function create_success($data) {
        return response()->json([
            'message' => 'Record Created Successfully',
            'type' => 'success',
            'data' => $data
        ], 200);
    }
}

if (! function_exists('edit_success')) {

    /**
     * Return edited successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function edit_success($data) {
        return response()->json([
            'message' => 'Record Edited Successfully',
            'type' => 'success',
            'data' => $data
        ], 200);
    }
}

if (! function_exists('delete_success')) {

    /**
     * Return deleted successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function delete_success($data) {
        return response()->json([
            'message' => 'Record Deleted Successfully',
            'type' => 'success',
            'data' => $data
        ], 200);
    }
}

if (! function_exists('found_success')) {

    /**
     * Return founded successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function found_success($data) {
        return response()->json([
            'message' => 'Record Founded Successfully',
            'type' => 'success',
            'data' => $data
        ], 200);
    }
}
