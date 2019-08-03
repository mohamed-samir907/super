<?php
use Samirz\Super\Exceptions\CanNotAccessException;

if (! function_exists('success_message')) {

    /**
     * Return Success Message Response
     *
     * @param  mixed $data
     * @return void
     */
    function success_message($message = '', $data = '')
    {
        return response()->json([
            "data" => [
                'message' => $message,
                'type' => 'success',
                'data' => $data
            ]
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
    function error_message($message = '', $code = 403, $data = '')
    {
        return response()->json([
            "data" => [
                'message' => $message,
                'type' => 'error',
                'data' => $data
            ]
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
            "data" => [
                'message' => trans('samirz::response.can_not_access'),
                'type' => 'error'
            ]
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
    function create_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.created_success'),
                'type' => 'success',
                'data' => $data
            ]
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
    function edit_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.edited_success'),
                'type' => 'success',
                'data' => $data
            ]
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
    function delete_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.deleted_success'),
                'type' => 'success',
                'data' => $data
            ]
        ], 200);
    }
}

if (! function_exists('found_success')) {

    /**
     * Return found successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function found_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.found_success'),
                'type' => 'success',
                'data' => $data
            ]
        ], 200);
    }
}

if (! function_exists('restore_success')) {

    /**
     * Return restored successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function restore_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.restored_success'),
                'type' => 'success',
                'data' => $data
            ]
        ], 200);
    }
}

if (! function_exists('force_success')) {

    /**
     * Return force deleted successfully response
     *
     * @param  mixed $data
     * @return \Response
     */
    function force_success($data = '') {
        return response()->json([
            "data" => [
                'message' => trans('samirz::response.force_success'),
                'type' => 'success',
                'data' => $data
            ]
        ], 200);
    }
}

if (! function_exists('check_ajax')) {

    /**
     * Check if the request is ajax or not
     *
     * @return \Illuminate\Http\Response|null
     */
    function check_ajax() {
        if (!request()->ajax()) {
            throw new CanNotAccessException();
        }
    }
}

if (! function_exists('if_true_return_resource')) {

    /**
     * Check if the returned data is true then return new resource else return error message
     *
     * @param mixed $data
     */
    function if_true_return_resource($data, $resource) {
        if ( $data )
            return new $resource( $data );
        else
            return error_message(trans('samirz::response.not_found'), 404);
    }
}

if (! function_exists('if_true_return_message')) {

    /**
     * Check if the returned data is true then return new resource else return error message
     *
     * @param mixed $data
     */
    function if_true_return_message($data, $message) {
        if ( $data )
            return $message;
        else
            return error_message(trans('samirz::response.not_found'), 404);
    }
}
